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
     * This is the key to fixing cart issues
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
     * This method handles both Auth and Guest users
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
                    'total'         => ($cartItem->price ?: $cartItem->product->product_price) * $cartItem->quantity,
                    'image'         => $cartItem->product->product_image,
                    'product'       => $cartItem->product,
                ];
            }
        }

        return $items;
    }

    /**
     * Add product to cart (No login required)
     */
    public function addToCart(Request $request, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);

            // Validate quantity
            $quantity = $request->quantity ? intval($request->quantity) : 1;

            if ($quantity < 1) {
                $quantity = 1;
            }

            // Check stock availability
            if ($product->product_quantity < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->product_quantity . ' items available in stock.',
                ], 400);
            }

            // Get session ID
            $sessionId = $this->getSessionId();

            Log::info('Adding to cart', [
                'product_id'      => $product_id,
                'quantity'        => $quantity,
                'cart_session_id' => $sessionId,
                'user_id'         => Auth::id(),
            ]);

            // Check if product is already in cart
            $existingCartItem = ProductAddCard::where('product_id', $product_id)
                ->where(function ($query) use ($sessionId) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if ($existingCartItem) {
                // Check if adding more exceeds stock
                $newQuantity = $existingCartItem->quantity + $quantity;
                if ($product->product_quantity < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more. Only ' . $product->product_quantity . ' items available in stock.',
                    ], 400);
                }

                // Update quantity
                $existingCartItem->quantity = $newQuantity;
                $existingCartItem->save();

                Log::info('Cart item updated', [
                    'cart_item_id' => $existingCartItem->id,
                    'new_quantity' => $newQuantity,
                ]);
            } else {
                // Add new item to cart
                $cartItem = ProductAddCard::create([
                    'session_id'    => $sessionId,
                    'user_id'       => Auth::id(),
                    'product_id'    => $product->id,
                    'product_title' => $product->product_title,
                    'price'         => $product->product_price,
                    'quantity'      => $quantity,
                ]);

                Log::info('New cart item created', [
                    'cart_item_id' => $cartItem->id,
                    'session_id'   => $sessionId,
                ]);
            }

            // Calculate cart count
            $cartCount = ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->sum('quantity');

            // Store cart count in session for quick access
            session(['cart_count' => $cartCount]);

            // Get cart items
            $cartItemsData = $this->getCartItems();

            return response()->json([
                'success'    => true,
                'message'    => 'Product added to cart successfully!',
                'cart_count' => $cartCount,
                'cart_items' => $cartItemsData,
            ]);

        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart. Please try again.',
            ], 500);
        }
    }

    /**
     * View cart items (No login required)
     */
    public function viewCart()
    {
        // Get session ID
        $sessionId = $this->getSessionId();

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

        // Pass database items to view
        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'total', 'itemCount'));
    }

    // This method is used internally to get cart items directly from the database for operations like update and remove
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
                    'total'         => ($cartItem->price ?: $cartItem->product->product_price) * $cartItem->quantity,
                    'product'       => $cartItem->product, // Keep product object for image access
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

            Log::info('Cart updated', [
                'cart_item_id' => $id,
                'new_quantity' => $quantity,
                'cart_count'   => $cartCount,
            ]);

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

            Log::info('Cart item removed', [
                'cart_item_id' => $id,
                'cart_count'   => $cartCount,
            ]);

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
    public function getCartCount()
    {
        $sessionId = $this->getSessionId();

        $cartCount = ProductAddCard::where(function ($query) use ($sessionId) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', $sessionId);
            }
        })->sum('quantity');

        // Store in session for consistency
        session(['cart_count' => $cartCount]);

        return response()->json([
            'count' => $cartCount,
        ]);
    }

    /**
     * Clear cart (No login required)
     */
    public function clearCart()
    {
        try {
            $sessionId = $this->getSessionId();

            $deletedCount = ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            session(['cart_count' => 0]);

            Log::info('Cart cleared', [
                'items_deleted' => $deletedCount,
                'session_id'    => $sessionId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'count'   => 0,
            ]);

        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart.',
            ], 500);
        }
    }

    /**
     * Confirm Order - No Login Required (Guest User)
     */
    public function confirmOrder(Request $request)
    {
        Log::info('Order confirmation started', [
            'request_data' => $request->all(),
            'user_id'      => Auth::id(),
            'session_data' => session()->all(),
        ]);

        // Validate request
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

        // Check terms separately
        if (! $request->has('terms') || $request->terms !== 'on') {
            Log::warning('Terms not accepted');
            return response()->json([
                'success' => false,
                'message' => 'You must agree to the Terms and Conditions.',
                'errors'  => ['terms' => 'You must agree to the Terms and Conditions.'],
            ], 422);
        }

        if ($validator->fails()) {
            Log::warning('Validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Please correct the errors below.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Get session ID
            $sessionId = $this->getSessionId();

            Log::info('Getting cart items for order', [
                'cart_session_id'    => $sessionId,
                'regular_session_id' => session()->getId(),
                'user_id'            => Auth::id(),
            ]);

            // Get cart items
            $cartItemsData = $this->getCartItems();

            if (empty($cartItemsData)) {
                Log::warning('Cart is empty when trying to place order', [
                    'session_id'           => $sessionId,
                    'user_id'              => Auth::id(),
                    'all_cart_items_in_db' => ProductAddCard::count(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty. Please add products to cart before confirming order.',
                ], 400);
            }

            // Check stock before proceeding
            foreach ($cartItemsData as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->product_quantity < $item['quantity']) {
                    $productName = $item['product_title'];
                    $available   = $product->product_quantity;

                    Log::warning('Insufficient stock', [
                        'product'   => $productName,
                        'requested' => $item['quantity'],
                        'available' => $available,
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$productName}. Only {$available} items available.",
                    ], 400);
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

            Log::info('Order totals calculated', [
                'subtotal'   => $subtotal,
                'tax'        => $tax,
                'total'      => $total,
                'item_count' => $itemCount,
                'shipping'   => $shipping,
            ]);

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
                'payment_method' => 'cash_on_delivery',
                'payment_status' => 'pending',
                'customer_type'  => Auth::check() ? 'registered' : 'guest',
            ];

            $order = ConfirmOrder::create($orderData);

            Log::info('Order created', [
                'order_id'       => $order->id,
                'order_number'   => $orderNumber,
                'customer_email' => $request->email,
            ]);

            // Create order items and update product stock
            foreach ($cartItemsData as $item) {
                // Create order item
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'product_title' => $item['product_title'],
                    'price'         => $item['price'],
                    'quantity'      => $item['quantity'],
                    'total'         => $item['price'] * $item['quantity'],
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $newQuantity               = $product->product_quantity - $item['quantity'];
                    $product->product_quantity = max(0, $newQuantity);
                    $product->save();

                    Log::info('Product stock updated', [
                        'product_id'   => $product->id,
                        'product_name' => $product->product_title,
                        'old_quantity' => $product->product_quantity + $item['quantity'],
                        'new_quantity' => $product->product_quantity,
                        'deducted'     => $item['quantity'],
                    ]);
                }
            }

            // Clear the cart after successful order
            $deletedCount = ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id())
                        ->orWhere('session_id', $sessionId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            // Clear cart count from session
            session(['cart_count' => 0]);

            Log::info('Cart cleared after order', [
                'items_deleted' => $deletedCount,
                'session_id'    => $sessionId,
            ]);

            // Store order info in session for guest access
            if (! Auth::check()) {
                session([
                    'guest_order_id'     => $order->id,
                    'guest_order_number' => $order->order_number,
                    'guest_order_email'  => $request->email,
                    'order_placed'       => true,
                ]);

                Log::info('Guest order session stored', [
                    'order_id'     => $order->id,
                    'order_number' => $order->order_number,
                ]);
            }

            DB::commit();

            Log::info('Order completed successfully', [
                'order_id'     => $order->id,
                'order_number' => $orderNumber,
                'customer'     => $request->name,
                'total'        => $total,
            ]);

            // Return success response
            return response()->json([
                'success'      => true,
                'message'      => 'Order placed successfully! Your order number is: ' . $order->order_number .
                '. You will receive a confirmation email shortly.',
                'order_number' => $order->order_number,
                'redirect'     => route('order.success', ['id' => $order->id]),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order confirmation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again. Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show order success page
     */
    public function orderSuccess($id)
    {
        try {
            $order = ConfirmOrder::findOrFail($id);

            // Additional security check for guests
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
                // For guests, also verify email
                if ($order->email == $request->email) {
                    session(['guest_tracked_order' => $order->id]);
                } else {
                    $order = null;
                }
            }
        }

        return view('cart.track-order', compact('order'));
    }

    /**
     * Merge guest cart with user cart after login
     */
    public function mergeCartAfterLogin()
    {
        if (Auth::check()) {
            try {
                // Get guest session ID from session
                $guestSessionId = session('cart_session_id');

                if ($guestSessionId) {
                    // Find guest cart items
                    $guestCartItems = ProductAddCard::where('session_id', $guestSessionId)
                        ->whereNull('user_id')
                        ->get();

                    if ($guestCartItems->count() > 0) {
                        foreach ($guestCartItems as $item) {
                            // Check if user already has this product in cart
                            $existingItem = ProductAddCard::where('user_id', Auth::id())
                                ->where('product_id', $item->product_id)
                                ->first();

                            if ($existingItem) {
                                // Update quantity
                                $existingItem->quantity += $item->quantity;
                                $existingItem->save();
                                $item->delete();
                            } else {
                                // Transfer to user
                                $item->user_id    = Auth::id();
                                $item->session_id = null;
                                $item->save();
                            }
                        }

                        Log::info('Cart merged after login', [
                            'user_id'           => Auth::id(),
                            'guest_session_id'  => $guestSessionId,
                            'items_transferred' => $guestCartItems->count(),
                        ]);
                    }

                    // Clear guest session ID
                    session()->forget('cart_session_id');
                }

                // Update session cart count
                $cartCount = ProductAddCard::where('user_id', Auth::id())->sum('quantity');
                session(['cart_count' => $cartCount]);

            } catch (\Exception $e) {
                Log::error('Error merging cart: ' . $e->getMessage());
            }
        }
    }

    /**
     * Checkout - Redirect to payment options
     * Add this method to your CartController
     */
    public function checkout()
    {
        // Get cart items
        $cartItems = $this->getCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals for session storage
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 50;
        $tax      = $subtotal * 0.05;
        $total    = $subtotal + $shipping + $tax;

        // Store order summary in session for payment options page
        session(['order_summary' => [
            'subtotal'   => $subtotal,
            'shipping'   => $shipping,
            'tax'        => $tax,
            'total'      => $total,
            'item_count' => count($cartItems),
        ]]);

        return redirect()->route('payment.options');
    }

    /**
     * Helper method to get cart count for views
     * This is different from getCartCount() which returns JSON
     */
    protected function getCartCountForView()
    {
        $sessionId = $this->getSessionId();

        return ProductAddCard::where(function ($query) use ($sessionId) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', $sessionId);
            }
        })->sum('quantity');
    }

    /**
     * Get raw cart items from database (for internal use)
     */
    private function getRawCartItems()
    {
        $sessionId = $this->getSessionId();

        return ProductAddCard::where(function ($query) use ($sessionId) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('product')->get();
    }
}
