<?php
namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAddCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * Constructor - Set Stripe API Key
     */
    public function __construct()
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Get cart count for current user/session
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return ProductAddCard::where('user_id', Auth::id())->sum('quantity');
        } else {
            if (! Session::has('cart_session_id')) {
                return 0;
            }

            $sessionId = Session::get('cart_session_id');
            return ProductAddCard::where('session_id', $sessionId)->sum('quantity');
        }
    }

    /**
     * Show payment options page
     */
    // PaymentController.php - showPaymentOptions method
    public function showPaymentOptions(Request $request)
    {
        // Get cart items from database
        $cartItems = $this->getCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $this->calculateSubtotal($cartItems);
        $shipping = 50;               // Fixed shipping cost
        $tax      = $subtotal * 0.05; // 5% tax
        $total    = $subtotal + $shipping + $tax;

        // Store order summary in session
        $orderSummary = [
            'subtotal'   => $subtotal,
            'shipping'   => $shipping,
            'tax'        => $tax,
            'total'      => $total,
            'item_count' => count($cartItems),
            'cart_items' => $cartItems, // This contains all cart items with details
        ];

        session(['order_summary' => $orderSummary]);

        // Get cart count
        $cartCount = $this->getCartCount();

        // Get user data if logged in
        $user = Auth::user();

        return view('payment.options', compact('orderSummary', 'cartCount', 'user'));
    }

    /**
     * Process Stripe Payment
     */
    public function processStripePayment(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes'   => 'nullable|string',
        ]);

        // Get order summary from session
        $orderSummary = session('order_summary');

        if (! $orderSummary) {
            return redirect()->route('cart.index')->with('error', 'Session expired. Please add items to cart again.');
        }

        // Check if cart items still exist
        $cartItems = $this->getCartItems();
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Create order in database (with pending status)
            $order = $this->createOrder($validated, $cartItems, $orderSummary, 'stripe');

            // Prepare line items for Stripe
            $lineItems = [];

            // Add product items
            foreach ($cartItems as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'        => $item['product_title'],
                            'description' => 'Quantity: ' . $item['quantity'],
                        ],
                        'unit_amount'  => round($item['price'] * 100), // Convert to cents
                    ],
                    'quantity'   => $item['quantity'],
                ];
            }

            // Add shipping as a line item
            if ($orderSummary['shipping'] > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Shipping Fee',
                        ],
                        'unit_amount'  => round($orderSummary['shipping'] * 100),
                    ],
                    'quantity'   => 1,
                ];
            }

            // Add tax as a line item
            if ($orderSummary['tax'] > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Tax (5%)',
                        ],
                        'unit_amount'  => round($orderSummary['tax'] * 100),
                    ],
                    'quantity'   => 1,
                ];
            }

            // Create Stripe Checkout Session
            $checkoutSession = StripeSession::create([
                'payment_method_types'        => ['card'],
                'line_items'                  => $lineItems,
                'mode'                        => 'payment',
                'success_url'                 => url('/payment/stripe/success/' . $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'                  => url('/payment/stripe/cancel/' . $order->id),
                'customer_email'              => $validated['email'],
                'client_reference_id'         => $order->order_number,
                'metadata'                    => [
                    'order_id'       => $order->id,
                    'order_number'   => $order->order_number,
                    'customer_name'  => $validated['name'],
                    'customer_email' => $validated['email'],
                ],
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA', 'GB', 'BD'], // Add more countries as needed
                ],
                'phone_number_collection'     => [
                    'enabled' => true,
                ],
            ]);

            // Update order with Stripe session ID
            $order->update([
                'stripe_session_id' => $checkoutSession->id,
                'payment_status'    => 'pending',
            ]);

            DB::commit();

            // Redirect to Stripe Checkout
            return redirect()->away($checkoutSession->url);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            \Log::error('Stripe Payment Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Stripe Payment Success
     */
    public function stripeSuccess(Request $request, $order_id)
    {
        try {
            $sessionId = $request->query('session_id');

            if (! $sessionId) {
                return redirect()->route('dashboard')->with('error', 'Invalid payment session.');
            }

            // Retrieve Stripe session
            $stripeSession = StripeSession::retrieve($sessionId);

            // Get order
            $order = ConfirmOrder::findOrFail($order_id);

            // Verify session matches order
            if ($order->stripe_session_id !== $sessionId) {
                return redirect()->route('dashboard')->with('error', 'Payment verification failed.');
            }

            // Check payment status
            if ($stripeSession->payment_status === 'paid') {
                // Update order status
                $order->update([
                    'status'                   => 'processing',
                    'payment_status'           => 'paid',
                    'stripe_payment_intent_id' => $stripeSession->payment_intent,
                    'paid_amount'              => $stripeSession->amount_total / 100, // Convert from cents
                    'payment_date'             => now(),
                ]);

                // Clear cart
                $this->clearCart();

                // Clear session order summary
                Session::forget('order_summary');

                return view('payment.success', [
                    'order'          => $order,
                    'payment_method' => 'Stripe/Card',
                    'transaction_id' => $stripeSession->payment_intent,
                    'amount_paid'    => $stripeSession->amount_total / 100,
                ]);
            }

            // If payment is not paid, show appropriate message
            return redirect()->route('payment.options')
                ->with('error', 'Payment was not completed. Please try again.');

        } catch (\Exception $e) {
            \Log::error('Stripe Success Error: ' . $e->getMessage());

            return redirect()->route('dashboard')
                ->with('error', 'Error verifying payment. Please contact support.');
        }
    }

    /**
     * Stripe Payment Cancel
     */
    public function stripeCancel($order_id)
    {
        try {
            $order = ConfirmOrder::findOrFail($order_id);

            // Only cancel if still pending
            if ($order->payment_status === 'pending') {
                $order->update([
                    'status'         => 'cancelled',
                    'payment_status' => 'cancelled',
                ]);
            }

            return redirect()->route('payment.options')
                ->with('error', 'Payment was cancelled. You can try again with a different payment method.');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }
    }

    /**
     * Process Cash on Delivery
     */
    public function processCashOnDelivery(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes'   => 'nullable|string',
        ]);

        // Get order summary from session
        $orderSummary = session('order_summary');

        if (! $orderSummary) {
            return redirect()->route('cart.index')->with('error', 'Session expired. Please add items to cart again.');
        }

        // Check if cart items still exist
        $cartItems = $this->getCartItems();
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = $this->createOrder($validated, $cartItems, $orderSummary, 'cash_on_delivery');

            // Clear cart
            $this->clearCart();

            // Clear session order summary
            Session::forget('order_summary');

            DB::commit();

            return view('payment.success', [
                'order'          => $order,
                'payment_method' => 'Cash on Delivery',
                'message'        => 'Your order has been placed successfully. Please have the exact amount ready for delivery.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('COD Order Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Order processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Process Mobile Banking Payment
     */
    public function processMobileBanking(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255',
            'phone'                 => 'required|string|max:20',
            'address'               => 'required|string|max:500',
            'mobile_banking_method' => 'required|in:bKash,Rocket,Nagad',
            'mobile_number'         => 'required|string|max:15|regex:/^01[3-9]\d{8}$/',
            'transaction_id'        => 'required|string|max:100|unique:confirm_orders,transaction_id',
            'notes'                 => 'nullable|string',
        ]);

        // Get order summary from session
        $orderSummary = session('order_summary');

        if (! $orderSummary) {
            return redirect()->route('cart.index')->with('error', 'Session expired. Please add items to cart again.');
        }

        // Check if cart items still exist
        $cartItems = $this->getCartItems();
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = $this->createOrder($validated, $cartItems, $orderSummary, 'mobile_banking');

            // Update with mobile banking details
            $order->update([
                'mobile_banking_method' => $validated['mobile_banking_method'],
                'mobile_number'         => $validated['mobile_number'],
                'transaction_id'        => $validated['transaction_id'],
                'payment_status'        => 'pending_verification',
            ]);

            // Clear cart
            $this->clearCart();

            // Clear session order summary
            Session::forget('order_summary');

            DB::commit();

            // Send email notification (you can implement this)
            // $this->sendMobileBankingPaymentEmail($order);

            return view('payment.mobile_banking_success', [
                'order'          => $order,
                'payment_method' => $validated['mobile_banking_method'],
                'mobile_number'  => $validated['mobile_number'],
                'transaction_id' => $validated['transaction_id'],
                'instructions'   => $this->getMobileBankingInstructions($validated['mobile_banking_method']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Mobile Banking Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Process Bank Transfer Payment
     */
    public function processBankTransfer(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:100|unique:confirm_orders,transaction_id',
            'notes'          => 'nullable|string',
        ]);

        // Get order summary from session
        $orderSummary = session('order_summary');

        if (! $orderSummary) {
            return redirect()->route('cart.index')->with('error', 'Session expired. Please add items to cart again.');
        }

        // Check if cart items still exist
        $cartItems = $this->getCartItems();
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = $this->createOrder($validated, $cartItems, $orderSummary, 'bank_transfer');

            // Update with bank transfer details
            $order->update([
                'bank_name'      => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'transaction_id' => $validated['transaction_id'],
                'payment_status' => 'pending_verification',
            ]);

            // Clear cart
            $this->clearCart();

            // Clear session order summary
            Session::forget('order_summary');

            DB::commit();

            // Send email notification (you can implement this)
            // $this->sendBankTransferEmail($order);

            return view('payment.bank_transfer_success', [
                'order'          => $order,
                'payment_method' => 'Bank Transfer',
                'bank_name'      => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'transaction_id' => $validated['transaction_id'],
                'bank_details'   => $this->getBankDetails(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Bank Transfer Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to get cart items
     */
    private function getCartItems()
    {
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
                    'product_id'    => $cartItem->product_id,
                    'product_title' => $cartItem->product->product_title,
                    'price'         => $cartItem->product->product_price,
                    'quantity'      => $cartItem->quantity,
                    'total'         => $cartItem->product->product_price * $cartItem->quantity,
                    'image'         => $cartItem->product->product_image,
                ];
            }
        }

        return $items;
    }

    /**
     * Helper method to calculate subtotal
     */
    private function calculateSubtotal($cartItems)
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    /**
     * Helper method to create order
     */
    private function createOrder($data, $cartItems, $orderSummary, $paymentMethod)
    {
        // Generate unique order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8));

        $customerType = Auth::check() ? 'registered' : 'guest';

        // Create order
        $order = ConfirmOrder::create([
            'order_number'   => $orderNumber,
            'user_id'        => Auth::id(),
            'session_id'     => Session::get('cart_session_id'),
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'address'        => $data['address'],
            'notes'          => $data['notes'] ?? null,
            'subtotal'       => $orderSummary['subtotal'],
            'shipping'       => $orderSummary['shipping'],
            'tax'            => $orderSummary['tax'],
            'total'          => $orderSummary['total'],
            'status'         => 'pending',
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'customer_type'  => $customerType,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item['product_id'],
                'product_title' => $item['product_title'],
                'price'         => $item['price'],
                'quantity'      => $item['quantity'],
                'total'         => $item['total'],
            ]);
        }

        return $order;
    }

    /**
     * Helper method to clear cart
     */
    private function clearCart()
    {
        if (Auth::check()) {
            ProductAddCard::where('user_id', Auth::id())->delete();
        } else {
            if (Session::has('cart_session_id')) {
                $sessionId = Session::get('cart_session_id');
                ProductAddCard::where('session_id', $sessionId)->delete();
                Session::forget('cart_session_id');
            }
        }
    }

    /**
     * Get mobile banking instructions
     */
    private function getMobileBankingInstructions($method)
    {
        $instructions = [
            'bKash'  => [
                'Send money to: 017XXXXXXXX',
                'Use your order number as reference',
                'Save the transaction ID for verification',
                'Payment will be verified within 2 hours',
            ],
            'Rocket' => [
                'Send money to: 017XXXXXXXX',
                'Use your order number as reference',
                'Save the transaction ID for verification',
                'Payment will be verified within 3 hours',
            ],
            'Nagad'  => [
                'Send money to: 017XXXXXXXX',
                'Use your order number as reference',
                'Save the transaction ID for verification',
                'Payment will be verified within 2 hours',
            ],
        ];

        return $instructions[$method] ?? [];
    }

    /**
     * Get bank details for transfer
     */
    private function getBankDetails()
    {
        return [
            'Account Name'   => 'Your Company Name',
            'Account Number' => '123456789',
            'Bank Name'      => 'City Bank Limited',
            'Branch'         => 'Gulshan Branch',
            'Routing Number' => '123456789',
            'SWIFT Code'     => 'CITIBDDX',
        ];
    }

    /**
     * Stripe Webhook Handler (Optional but recommended)
     */
    public function handleStripeWebhook(Request $request)
    {
        // This is for handling Stripe webhooks in production
        // You'll need to set up webhook endpoint in Stripe dashboard

        $payload         = $request->getContent();
        $sig_header      = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook.secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;

            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;

                // Add more event types as needed
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle checkout session completed
     */
    private function handleCheckoutSessionCompleted($session)
    {
        // Find order by stripe session ID
        $order = ConfirmOrder::where('stripe_session_id', $session->id)->first();

        if ($order) {
            $order->update([
                'payment_status'           => 'paid',
                'stripe_payment_intent_id' => $session->payment_intent,
                'paid_amount'              => $session->amount_total / 100,
                'payment_date'             => now(),
                'status'                   => 'processing',
            ]);
        }
    }

    /**
     * Handle payment intent succeeded
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Find order by payment intent ID
        $order = ConfirmOrder::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'paid',
                'paid_amount'    => $paymentIntent->amount / 100,
                'payment_date'   => now(),
            ]);
        }
    }
}
