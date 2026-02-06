<?php
namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAddCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Get cart items - Guest and User both
    public function index()
    {
        $sessionId = $this->getSessionId();

        // Get cart items for guest session or logged-in user
        if (auth()->check()) {
            $cartItems = ProductAddCard::where('user_id', auth()->id())
                ->with('product')
                ->get();
        } else {
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->with('product')
                ->get();
        }

        // Calculate totals
        $subtotal  = 0;
        $itemCount = 0;

        foreach ($cartItems as $item) {
            $subtotal  += $item->price * $item->quantity;
            $itemCount += $item->quantity;
        }

        $shipping = 0;
        $tax      = $subtotal * 0.10;
        $total    = $subtotal + $shipping + $tax;

        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'itemCount'));
    }

    // Add to cart
    public function addToCart(Request $request, $productId)
    {
        try {
            $product  = Product::findOrFail($productId);
            $quantity = $request->input('quantity', 1);

            // Validate quantity
            if ($quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity must be at least 1',
                ], 422);
            }

            // Check stock availability
            if ($product->product_quantity < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->product_quantity . ' items available.',
                ], 422);
            }

            if (auth()->check()) {
                // For logged-in user
                $cartItem = ProductAddCard::where('user_id', auth()->id())
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                    $message  = 'Product quantity updated in cart!';
                } else {
                    ProductAddCard::create([
                        'user_id'       => auth()->id(),
                        'session_id'    => null,
                        'product_id'    => $productId,
                        'quantity'      => $quantity,
                        'price'         => $product->product_price,
                        'product_title' => $product->product_title,
                    ]);
                    $message = 'Product added to cart successfully!';
                }
            } else {
                // For guest user
                $sessionId = $this->getSessionId();
                $cartItem  = ProductAddCard::where('session_id', $sessionId)
                    ->where('product_id', $productId)
                    ->whereNull('user_id')
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                    $message  = 'Product quantity updated in cart!';
                } else {
                    ProductAddCard::create([
                        'session_id'    => $sessionId,
                        'user_id'       => null,
                        'product_id'    => $productId,
                        'quantity'      => $quantity,
                        'price'         => $product->product_price,
                        'product_title' => $product->product_title,
                    ]);
                    $message = 'Product added to cart successfully!';
                }
            }

            $cartCount = $this->getCartCount();

            return response()->json([
                'success'    => true,
                'message'    => $message,
                'cart_count' => $cartCount,
                'product'    => [
                    'id'    => $product->id,
                    'title' => $product->product_title,
                    'price' => $product->product_price,
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart. Please try again.',
            ], 500);
        }
    }

    // Remove from cart
    public function removeFromCart($id)
    {
        try {
            if (auth()->check()) {
                $cartItem = ProductAddCard::where('user_id', auth()->id())
                    ->where('id', $id)
                    ->first();
            } else {
                $sessionId = $this->getSessionId();
                $cartItem  = ProductAddCard::where('session_id', $sessionId)
                    ->where('id', $id)
                    ->whereNull('user_id')
                    ->first();
            }

            if ($cartItem) {
                $cartItem->delete();
            }

            return response()->json([
                'success'    => true,
                'message'    => 'Product removed from cart',
                'cart_count' => $this->getCartCount(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Remove from cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from cart.',
            ], 500);
        }
    }

    // Update cart quantity
    public function updateCart(Request $request, $id)
    {
        try {
            $quantity = $request->input('quantity', 1);

            if ($quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity must be at least 1',
                ], 422);
            }

            // Get cart item
            if (auth()->check()) {
                $cartItem = ProductAddCard::where('user_id', auth()->id())
                    ->where('id', $id)
                    ->first();
            } else {
                $sessionId = $this->getSessionId();
                $cartItem  = ProductAddCard::where('session_id', $sessionId)
                    ->where('id', $id)
                    ->whereNull('user_id')
                    ->first();
            }

            if (! $cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found',
                ], 404);
            }

            // Check stock if updating quantity
            $product = $cartItem->product;
            if ($product && $product->product_quantity < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->product_quantity . ' items available.',
                ], 422);
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();

            $newTotal = $cartItem->price * $quantity;

            return response()->json([
                'success'    => true,
                'message'    => 'Cart updated successfully',
                'cart_count' => $this->getCartCount(),
                'new_total'  => number_format($newTotal, 2),
                'item_total' => '$' . number_format($newTotal, 2),
            ]);

        } catch (\Exception $e) {
            \Log::error('Update cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart.',
            ], 500);
        }
    }

    // Get cart count
    public function getCartCount()
    {
        if (auth()->check()) {
            return ProductAddCard::where('user_id', auth()->id())->sum('quantity');
        } else {
            $sessionId = $this->getSessionId();
            return ProductAddCard::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->sum('quantity');
        }
    }

    // API to get cart count
    public function getCartCountApi()
    {
        return response()->json([
            'count' => $this->getCartCount(),
        ]);
    }

    // Get cart data
    public function getCartData()
    {
        if (auth()->check()) {
            $cartItems = ProductAddCard::where('user_id', auth()->id())
                ->with('product')
                ->get();
        } else {
            $sessionId = $this->getSessionId();
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->with('product')
                ->get();
        }

        $subtotal  = 0;
        $itemCount = 0;

        foreach ($cartItems as $item) {
            $subtotal  += $item->price * $item->quantity;
            $itemCount += $item->quantity;
        }

        $tax   = $subtotal * 0.10;
        $total = $subtotal + $tax;

        return response()->json([
            'items'      => $cartItems,
            'subtotal'   => $subtotal,
            'tax'        => $tax,
            'total'      => $total,
            'item_count' => $itemCount,
            'count'      => $cartItems->count(),
        ]);
    }

    /**
     * Confirm Order - Guest User (No Login Required)
     */
    /**
     * Confirm Order - Guest User (No Login Required)
     */
    public function confirmOrder(Request $request)
    {
        \Log::info('Order confirmation started', ['request_data' => $request->all()]);

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
            \Log::warning('Terms not accepted');
            return response()->json([
                'success' => false,
                'message' => 'You must agree to the Terms and Conditions.',
                'errors'  => ['terms' => 'You must agree to the Terms and Conditions.'],
            ], 422);
        }

        if ($validator->fails()) {
            \Log::warning('Validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Please correct the errors below.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Get cart items
            $sessionId = $this->getSessionId();
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->with('product')
                ->get();

            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                \Log::warning('Empty cart attempt', ['session_id' => $sessionId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty. Please add products before confirming order.',
                ], 400);
            }

            // Check stock before proceeding
            foreach ($cartItems as $item) {
                if ($item->product && $item->product->product_quantity < $item->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock for ' . $item->product_title . '. Only ' . $item->product->product_quantity . ' items available.',
                    ], 400);
                }
            }

            // Calculate totals
            $subtotal  = 0;
            $itemCount = 0;

            foreach ($cartItems as $item) {
                $subtotal  += $item->price * $item->quantity;
                $itemCount += $item->quantity;
            }

            $shipping = 0;
            $tax      = round($subtotal * 0.10, 2);
            $total    = round($subtotal + $shipping + $tax, 2);

            \Log::info('Calculated totals', [
                'subtotal'   => $subtotal,
                'tax'        => $tax,
                'total'      => $total,
                'item_count' => $itemCount,
            ]);

            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(Str::random(6)) . '-' . date('YmdHis');

            // Create ConfirmOrder for guest
            $order = ConfirmOrder::create([
                'user_id'        => null,
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
                'customer_type'  => 'guest',
            ]);

            \Log::info('Order created', [
                'order_id'     => $order->id,
                'order_number' => $orderNumber,
            ]);

            // Create Order Items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $cartItem->product_id,
                    'product_title' => $cartItem->product_title,
                    'price'         => $cartItem->price,
                    'quantity'      => $cartItem->quantity,
                    'total'         => $cartItem->price * $cartItem->quantity,
                ]);

                // Update product stock
                if ($cartItem->product) {
                    $product                   = $cartItem->product;
                    $newQuantity               = $product->product_quantity - $cartItem->quantity;
                    $product->product_quantity = max(0, $newQuantity);
                    $product->save();

                    \Log::info('Product stock updated', [
                        'product_id'   => $product->id,
                        'old_quantity' => $product->product_quantity + $cartItem->quantity,
                        'new_quantity' => $product->product_quantity,
                    ]);
                }
            }

            // Clear the cart after order is placed
            $deletedCount = ProductAddCard::where('session_id', $sessionId)->delete();
            \Log::info('Cart cleared', ['items_deleted' => $deletedCount]);

            // Store order info in session for guest access
            Session::put('guest_order_id', $order->id);
            Session::put('guest_order_number', $order->order_number);
            Session::put('order_placed', true);
            Session::put('order_email', $request->email);

            DB::commit();

            \Log::info('Order completed successfully', [
                'order_id'     => $order->id,
                'order_number' => $orderNumber,
            ]);

            // Return JSON response for AJAX
            return response()->json([
                'success'  => true,
                'message'  => 'Order placed successfully! Your order number is: ' . $order->order_number,
                'redirect' => route('order.success', ['id' => $order->id]),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Order confirmation error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again. Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Order Success Page
     */
    public function orderSuccess($id)
    {
        try {
            \Log::info('Accessing order success page', ['order_id' => $id]);

            $order = ConfirmOrder::with('items')->find($id);

            if (! $order) {
                \Log::warning('Order not found', ['order_id' => $id]);
                return redirect()->route('cart.index')
                    ->with('error', 'Order not found. Please check your order number.');
            }

            // Check access
            $hasAccess = false;
            $sessionId = $this->getSessionId();

            // Check session
            if (Session::get('guest_order_id') == $id) {
                $hasAccess = true;
            }

            // Check if order belongs to current session
            if ($order->session_id == $sessionId) {
                $hasAccess = true;
            }

            // Check if order was created recently (last 30 minutes)
            if ($order->created_at->diffInMinutes(now()) < 30) {
                $hasAccess = true;
            }

            if (! $hasAccess) {
                \Log::warning('Unauthorized access to order', [
                    'order_id'      => $id,
                    'session_id'    => $sessionId,
                    'order_session' => $order->session_id,
                ]);

                return redirect()->route('order.track')
                    ->with('warning', 'Please enter your order details to view order information.');
            }

            // Clear order session after viewing
            Session::forget(['guest_order_id', 'guest_order_number']);

            return view('cart.order_success', compact('order'));

        } catch (\Exception $e) {
            \Log::error('Order success page error: ' . $e->getMessage());
            return redirect()->route('cart.index')
                ->with('error', 'An error occurred while loading order details.');
        }
    }

   
    /**
     * Clear Cart
     */
    public function clearCart()
    {
        try {
            if (auth()->check()) {
                $deleted = ProductAddCard::where('user_id', auth()->id())->delete();
            } else {
                $sessionId = $this->getSessionId();
                $deleted   = ProductAddCard::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'count'   => 0,
            ]);

        } catch (\Exception $e) {
            \Log::error('Clear cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart.',
            ], 500);
        }
    }

    /**
     * Get or create session ID for guest
     */
    private function getSessionId()
    {
        if (! Session::has('cart_session_id')) {
            $sessionId = 'guest_' . uniqid() . '_' . time();
            Session::put('cart_session_id', $sessionId);
            \Log::info('New session created', ['session_id' => $sessionId]);
        }

        return Session::get('cart_session_id');
    }

    /**
     * Merge guest cart with user cart on login
     */
    public function mergeCartOnLogin($userId)
    {
        try {
            $sessionId = $this->getSessionId();

            // Get guest cart items
            $guestCartItems = ProductAddCard::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();

            foreach ($guestCartItems as $guestItem) {
                // Check if user already has this product in cart
                $userCartItem = ProductAddCard::where('user_id', $userId)
                    ->where('product_id', $guestItem->product_id)
                    ->first();

                if ($userCartItem) {
                    // Update quantity
                    $userCartItem->quantity += $guestItem->quantity;
                    $userCartItem->save();
                    $guestItem->delete();
                } else {
                    // Transfer to user
                    $guestItem->update([
                        'user_id'    => $userId,
                        'session_id' => null,
                    ]);
                }
            }

            \Log::info('Cart merged on login', [
                'user_id'      => $userId,
                'items_merged' => $guestCartItems->count(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Cart merge error: ' . $e->getMessage());
        }
    }

    /**
     * Clear old guest sessions (optional - can be run via cron)
     */
    private function clearOldGuestSessions()
    {
        try {
            // Clear sessions older than 7 days
            $cutoffDate = now()->subDays(7);

            $oldSessions = ConfirmOrder::where('customer_type', 'guest')
                ->where('created_at', '<', $cutoffDate)
                ->whereNotNull('session_id')
                ->pluck('session_id')
                ->unique()
                ->toArray();

            if (! empty($oldSessions)) {
                $deleted = ProductAddCard::whereIn('session_id', $oldSessions)->delete();
                \Log::info('Cleared old guest sessions', [
                    'sessions'      => count($oldSessions),
                    'items_deleted' => $deleted,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Clear old sessions error: ' . $e->getMessage());
        }
    }
}
