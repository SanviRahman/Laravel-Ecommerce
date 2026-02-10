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

class OrderController extends Controller
{
    /**
     * Show order confirmation page
     */
    public function showConfirmOrder()
    {
        // Get cart items
        $cartItems = $this->getCartItems();
        
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals for display
        $subtotal = 0;
        $itemCount = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }
        
        $shipping = 50;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        return view('cart.order-confirm', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'itemCount'));
    }

    /**
     * Create order (without payment)
     */
    public function createOrder(Request $request)
    {
        Log::info('Creating order without payment', [
            'user_id' => Auth::id(),
            'session_id' => session()->getId()
        ]);

        // Validate request
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20|min:10',
            'address' => 'required|string|min:10',
            'notes'   => 'nullable|string|max:500',
        ]);

        // Check terms
        if (!$request->has('terms') || $request->terms !== 'on') {
            return response()->json([
                'success' => false,
                'message' => 'You must agree to the Terms and Conditions.'
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the errors.',
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Get session ID
            $sessionId = session('cart_session_id');
            if (!$sessionId) {
                $sessionId = 'cart_' . Str::random(20) . '_' . time();
                session(['cart_session_id' => $sessionId]);
            }

            // Get cart items
            $cartItems = $this->getCartItems();

            if (empty($cartItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ], 400);
            }

            // Check stock
            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->product_quantity < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$item['product_title']}. Only {$product->product_quantity} items available."
                    ], 400);
                }
            }

            // Calculate totals
            $subtotal = 0;
            $itemCount = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
                $itemCount += $item['quantity'];
            }

            $shipping = 50;
            $tax = round($subtotal * 0.05, 2);
            $total = round($subtotal + $shipping + $tax, 2);

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Create order (without payment)
            $order = ConfirmOrder::create([
                'order_number'   => $orderNumber,
                'user_id'        => Auth::id(),
                'session_id'     => $sessionId,
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
                'payment_method' => null,
                'payment_status' => 'pending',
                'customer_type'  => Auth::check() ? 'registered' : 'guest',
                'is_paid'        => false,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
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
                    $newQuantity = $product->product_quantity - $item['quantity'];
                    $product->product_quantity = max(0, $newQuantity);
                    $product->save();
                }
            }

            // Clear cart
            $this->clearCart($sessionId);

            // Store order ID in session for payment
            session([
                'current_order_id' => $order->id,
                'order_confirmed'  => true
            ]);

            DB::commit();

            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'order_number' => $orderNumber
            ]);

            return response()->json([
                'success'      => true,
                'message'      => 'Order confirmed successfully!',
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'total'        => $total,
                'redirect'     => route('payment.options') . '?order_id=' . $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Order creation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart items
     */
    private function getCartItems()
    {
        $sessionId = session('cart_session_id');

        if (Auth::check()) {
            $cartItems = ProductAddCard::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            if (!$sessionId) {
                return [];
            }
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        $items = [];
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product) {
                $items[] = [
                    'product_id'    => $cartItem->product_id,
                    'product_title' => $cartItem->product_title ?: $cartItem->product->product_title,
                    'price'         => $cartItem->price ?: $cartItem->product->product_price,
                    'quantity'      => $cartItem->quantity,
                    'image'         => $cartItem->product->product_image,
                    'product'       => $cartItem->product,
                ];
            }
        }

        return $items;
    }

    /**
     * Clear cart
     */
    private function clearCart($sessionId)
    {
        if (Auth::check()) {
            ProductAddCard::where('user_id', Auth::id())->delete();
        } else {
            if ($sessionId) {
                ProductAddCard::where('session_id', $sessionId)->delete();
            }
        }

        session(['cart_count' => 0]);
        Session::forget('cart_session_id');
    }

    /**
     * Show track order form
     */
    public function trackOrder()
    {
        return view('cart.order_track');
    }

    /**
     * Handle track order form submission
     */
    public function trackOrderPost(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string|max:50',
            'email' => 'required|email'
        ]);

        // Find order by order number and email
        $order = ConfirmOrder::where('order_number', $request->order_number)
            ->where('email', $request->email)
            ->with('orderItems')
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found. Please check your order number and email.');
        }

        return view('cart.order_details', compact('order'));
    }

    /**
     * Show order details for tracking
     */
    public function showOrderDetails($order_number)
    {
        $order = ConfirmOrder::where('order_number', $order_number)
            ->with('orderItems')
            ->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        return view('cart.order_details', compact('order'));
    }

    /**
     * Show payment page for specific order
     */
    public function showPaymentForOrder($id)
    {
        $order = ConfirmOrder::findOrFail($id);
        
        // Check if order is already paid
        if ($order->is_paid) {
            return redirect()->route('order.success', ['id' => $order->id])
                ->with('info', 'This order has already been paid.');
        }

        return view('payment.options', compact('order'));
    }

    /**
     * Show order success page
     */
    public function orderSuccess($id)
    {
        $order = ConfirmOrder::findOrFail($id);
        return view('orders.success', compact('order'));
    }
}