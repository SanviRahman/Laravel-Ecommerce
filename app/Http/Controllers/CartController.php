<?php
namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAddCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get or create session ID for cart
     */
    protected function getSessionId()
    {
        $sessionId = session('cart_session_id');

        if (! $sessionId) {
            $sessionId = 'cart_' . Str::random(20) . '_' . time();
            session(['cart_session_id' => $sessionId]);
        }

        return $sessionId;
    }

    /**
     * Get cart items for the current session/user
     */
    private function getCartItems()
    {
        $sessionId = $this->getSessionId();

        $cartItems = ProductAddCard::where(function ($query) use ($sessionId) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('product')->get();

        // Convert to array format for consistency
        $items = [];
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product) {
                $items[] = [
                    'product_id'    => $cartItem->product_id,
                    'cart_item_id'  => $cartItem->id,
                    'product_title' => $cartItem->product_title ?: $cartItem->product->product_title,
                    'price'         => $cartItem->price ?: $cartItem->product->product_price,
                    'quantity'      => $cartItem->quantity,
                    'size'          => $cartItem->size,
                    'total'         => ($cartItem->price ?: $cartItem->product->product_price) * $cartItem->quantity,
                    'image'         => $cartItem->product->product_image,
                    'product'       => $cartItem->product,
                ];
            }
        }

        return $items;
    }

    /**
     * Add product to cart (No login required) - REDIRECT VERSION
     */
    public function addToCart(Request $request, $product_id)
    {
        try {
            $product  = Product::findOrFail($product_id);
            $quantity = $request->quantity ? intval($request->quantity) : 1;
            $size     = $request->size;

            if ($quantity < 1) {
                $quantity = 1;
            }

            // Check stock availability
            if ($product->product_quantity < $quantity) {
                return redirect()->back()->with('error', 'Only ' . $product->product_quantity . ' items available in stock.');
            }

            // For clothes category, size is required
            if ($product->isClothesCategory() && empty($size)) {
                return redirect()->back()->with('error', 'Please select a size.');
            }

            $sessionId = $this->getSessionId();

            // Check if product with same size is already in cart
            $existingCartItem = ProductAddCard::where('product_id', $product_id)
                ->where(function ($query) use ($sessionId) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->when($size, function ($query, $size) {
                    return $query->where('size', $size);
                })
                ->first();

            if ($existingCartItem) {
                $newQuantity = $existingCartItem->quantity + $quantity;
                if ($product->product_quantity < $newQuantity) {
                    return redirect()->back()->with('error', 'Cannot add more. Only ' . $product->product_quantity . ' items available in stock.');
                }

                $existingCartItem->quantity = $newQuantity;
                $existingCartItem->save();
            } else {
                ProductAddCard::create([
                    'session_id'    => $sessionId,
                    'user_id'       => Auth::id(),
                    'product_id'    => $product->id,
                    'product_title' => $product->product_title,
                    'price'         => $product->product_price,
                    'quantity'      => $quantity,
                    'size'          => $size,
                ]);
            }

            $cartCount = ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->sum('quantity');

            session(['cart_count' => $cartCount]);

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add product to cart. Please try again.');
        }
    }

    /**
     * View cart items (No login required)
     */
    public function viewCart()
    {
        // Get cart items from database
        $cartItems = $this->getCartItemsFromDatabase();

        // Calculate totals
        $subtotal  = 0;
        $itemCount = 0;

        foreach ($cartItems as $item) {
            $subtotal  += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }

        $tax   = $subtotal * 0.10;
        $total = $subtotal + $tax;

        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'total', 'itemCount'));
    }

    private function getCartItemsFromDatabase()
    {
        $sessionId = $this->getSessionId();

        if (Auth::check()) {
            $cartItems = ProductAddCard::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            if (! Session::has('cart_session_id')) {
                return [];
            }

            $sessionId = Session::get('cart_session_id');
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        $items = [];
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product) {
                $items[] = [
                    'id'            => $cartItem->id,
                    'product_id'    => $cartItem->product_id,
                    'product_title' => $cartItem->product_title ?: $cartItem->product->product_title,
                    'price'         => $cartItem->price ?: $cartItem->product->product_price,
                    'quantity'      => $cartItem->quantity,
                    'size'          => $cartItem->size,
                    'total'         => ($cartItem->price ?: $cartItem->product->product_price) * $cartItem->quantity,
                    'product'       => $cartItem->product,
                ];
            }
        }

        return $items;
    }

    /**
     * Update cart item quantity (No login required)
     */
    public function updateCart(Request $request, $id)
    {
        try {
            $quantity = intval($request->quantity);

            if ($quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity must be at least 1.',
                ], 400);
            }

            $sessionId = $this->getSessionId();

            // Find cart item
            $cartItem = ProductAddCard::where('id', $id)
                ->where(function ($query) use ($sessionId) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->firstOrFail();

            // Check product stock
            $product = Product::find($cartItem->product_id);
            if ($product && $product->product_quantity < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->product_quantity . ' items available in stock.',
                ], 400);
            }

            // Update quantity
            $cartItem->quantity = $quantity;
            $cartItem->save();

            // Get updated cart items
            $cartItems = $this->getCartItems();
            $cartCount = collect($cartItems)->sum('quantity');

            session(['cart_count' => $cartCount]);

            return response()->json([
                'success'    => true,
                'message'    => 'Cart updated successfully.',
                'cart_count' => $cartCount,
                'cart_items' => $cartItems,
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart.',
            ], 500);
        }
    }

    /**
     * Remove item from cart (No login required)
     */
    public function removeFromCart($id)
    {
        try {
            $sessionId = $this->getSessionId();

            // Find and delete cart item
            $cartItem = ProductAddCard::where('id', $id)
                ->where(function ($query) use ($sessionId) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->firstOrFail();

            $cartItem->delete();

            // Get updated cart items
            $cartItems = $this->getCartItems();
            $cartCount = collect($cartItems)->sum('quantity');

            session(['cart_count' => $cartCount]);

            return response()->json([
                'success'    => true,
                'message'    => 'Item removed from cart.',
                'cart_count' => $cartCount,
                'cart_items' => $cartItems,
            ]);

        } catch (\Exception $e) {
            Log::error('Error removing from cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart.',
            ], 500);
        }
    }

    /**
     * Get cart count (No login required)
     */
    public function getCartCountApi()
    {
        $sessionId = $this->getSessionId();

        $cartCount = ProductAddCard::where(function ($query) use ($sessionId) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', $sessionId);
            }
        })->sum('quantity');

        session(['cart_count' => $cartCount]);

        return response()->json([
            'count' => $cartCount,
        ]);
    }

    /**
     * Buy Now - Add product to cart and redirect to checkout
     */
    public function buyNow(Request $request, $product_id)
    {
        try {
            $product  = Product::findOrFail($product_id);
            $quantity = $request->quantity ? intval($request->quantity) : 1;
            $size     = $request->size;

            if ($quantity < 1) {
                $quantity = 1;
            }

            if ($product->product_quantity < $quantity) {
                return redirect()->back()->with('error', 'Only ' . $product->product_quantity . ' items available in stock.');
            }

            // For clothes category, size is required
            if ($product->isClothesCategory() && empty($size)) {
                return redirect()->back()->with('error', 'Please select a size.');
            }

            $sessionId = $this->getSessionId();

            $existingCartItem = ProductAddCard::where('product_id', $product_id)
                ->where(function ($query) use ($sessionId) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->when($size, function ($query, $size) {
                    return $query->where('size', $size);
                })
                ->first();

            if ($existingCartItem) {
                $newQuantity = $existingCartItem->quantity + $quantity;
                if ($product->product_quantity < $newQuantity) {
                    return redirect()->back()->with('error', 'Cannot add more. Only ' . $product->product_quantity . ' items available in stock.');
                }
                $existingCartItem->quantity = $newQuantity;
                $existingCartItem->save();
            } else {
                ProductAddCard::create([
                    'session_id'    => $sessionId,
                    'user_id'       => Auth::id(),
                    'product_id'    => $product->id,
                    'product_title' => $product->product_title,
                    'price'         => $product->product_price,
                    'quantity'      => $quantity,
                    'size'          => $size,
                ]);
            }

            $cartCount = ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->sum('quantity');

            session(['cart_count' => $cartCount]);

            return redirect()->route('cart.confirm')->with('success', 'Product added to cart. Please complete your order.');

        } catch (\Exception $e) {
            Log::error('Error in buy now: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process buy now request. Please try again.');
        }
    }

    /**
     * Show order confirmation form
     */
    public function showOrderConfirmForm()
    {
        $cartItems = $this->getCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal  = 0;
        $itemCount = 0;

        foreach ($cartItems as $item) {
            $subtotal  += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }

        $shipping = 0;
        $tax      = $subtotal * 0.10;
        $total    = $subtotal + $shipping + $tax;

        return view('cart.confirm-order', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'itemCount'));
    }

    /**
     * Process order confirmation
     */
    public function processOrderConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20|min:10',
            'address' => 'required|string|min:10',
            'notes'   => 'nullable|string|max:500',
        ], [
            'name.required'    => 'Please enter your full name.',
            'email.required'   => 'Please enter your email address.',
            'email.email'      => 'Please enter a valid email address.',
            'phone.required'   => 'Please enter your phone number.',
            'phone.min'        => 'Phone number must be at least 10 digits.',
            'address.required' => 'Please enter your shipping address.',
            'address.min'      => 'Address must be at least 10 characters.',
        ]);

        // Check terms agreement
        if (! $request->has('terms') || $request->terms !== 'on') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You must agree to the Terms and Conditions.');
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $sessionId     = $this->getSessionId();
            $cartItemsData = $this->getCartItems();

            if (empty($cartItemsData)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty. Please add products to cart before confirming order.');
            }

            // Check stock before proceeding
            foreach ($cartItemsData as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->product_quantity < $item['quantity']) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Insufficient stock for {$item['product_title']}. Only {$product->product_quantity} items available.");
                }
            }

            // Calculate totals
            $subtotal  = 0;
            $itemCount = 0;

            foreach ($cartItemsData as $item) {
                $subtotal  += $item['price'] * $item['quantity'];
                $itemCount += $item['quantity'];
            }

            $shipping = 0;
            $tax      = round($subtotal * 0.10, 2);
            $total    = round($subtotal + $shipping + $tax, 2);

            // Generate unique order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Create order record
            $orderData = [
                'user_id'        => Auth::id(),
                'session_id'     => $sessionId,
                'order_number'   => $orderNumber,
                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'notes'          => $request->notes,
                'subtotal'       => $subtotal,
                'shipping'       => $shipping,
                'tax'            => $tax,
                'total'          => $total,
                'status'         => 'pending',
                'payment_method' => 'pending',
                'payment_status' => 'pending',
                'customer_type'  => Auth::check() ? 'registered' : 'guest',
            ];

            $order  = ConfirmOrder::create($orderData);

            // Create order items
            foreach ($cartItemsData as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'product_title' => $item['product_title'],
                    'price'         => $item['price'],
                    'quantity'      => $item['quantity'],
                    'size'          => $item['size'] ?? null,
                    'total'         => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Store ALL order data in session for payment page
            session([
                'current_order_id' => $order->id,
                'order_summary'    => [
                    'subtotal'     => $subtotal,
                    'shipping'     => $shipping,
                    'tax'          => $tax,
                    'total'        => $total,
                    'order_number' => $orderNumber,
                ],
                // Store customer information separately
                'customer_info'    => [
                    'name'    => $request->name,
                    'email'   => $request->email,
                    'phone'   => $request->phone,
                    'address' => $request->address,
                    'notes'   => $request->notes,
                ],
            ]);

            // Clear the cart after successful order
            ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id())
                        ->orWhere('session_id', $sessionId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            session(['cart_count' => 0]);

            if (! Auth::check()) {
                session([
                    'guest_order_id'     => $order->id,
                    'guest_order_number' => $order->order_number,
                    'guest_order_email'  => $request->email,
                ]);
            }

            // Redirect to payment options
            return redirect()->route('payment.options', ['order_id' => $order->id])
                ->with('success', 'Order confirmed! Please select your payment method.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order confirmation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Show order success page
     */
    public function orderSuccess($id)
    {
        try {
            $order = ConfirmOrder::findOrFail($id);

            if (! Auth::check()) {
                $guestOrderId = session('guest_order_id');
                if ($guestOrderId != $id) {
                    abort(403, 'Unauthorized access to order details.');
                }
            }

            $orderItems = OrderItem::where('order_id', $id)->get();

            return view('cart.order-success', compact('order', 'orderItems'));

        } catch (\Exception $e) {
            Log::error('Error showing order success: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }
    }

    /**
     * Track order for guest users
     */
    public function trackOrder(Request $request)
    {
        $order = null;

        if ($request->has('order_number')) {
            $order = ConfirmOrder::where('order_number', $request->order_number)->first();

            if ($order && ! Auth::check()) {
                if ($order->email == $request->email) {
                    session(['guest_tracked_order' => $order->id]);
                } else {
                    $order = null;
                }
            }
        }

        return view('cart.track-order', compact('order'));
    }
}
