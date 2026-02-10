<?php
namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
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
    public function showPaymentOptions(Request $request)
    {
        // Check if we have order_id in query parameter or session
        $orderId = $request->query('order_id') ?? session('current_order_id');

        if (! $orderId) {
            return redirect()->route('cart.confirm')
                ->with('error', 'Please confirm your order first.');
        }

        // Get order
        $order = ConfirmOrder::with('items')->find($orderId);

        if (! $order) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }

        // Security check
        if (Auth::check()) {
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access.');
            }
        } else {
            $sessionOrderId = session('current_order_id');
            if ($sessionOrderId != $orderId) {
                abort(403, 'Unauthorized access.');
            }
        }

        // Check if order is already paid
        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', ['id' => $order->id])
                ->with('info', 'This order is already paid.');
        }

        // Prepare order summary from order data
        $orderSummary = [
            'subtotal'     => $order->subtotal,
            'shipping'     => $order->shipping,
            'tax'          => $order->tax,
            'total'        => $order->total,
            'item_count'   => $order->items->count(),
            'order_id'     => $order->id,
            'order_number' => $order->order_number,
            'cart_items'   => $order->items->map(function ($item) {
                return [
                    'product_title' => $item->product_title,
                    'price'         => $item->price,
                    'quantity'      => $item->quantity,
                    'total'         => $item->total,
                ];
            })->toArray(),
        ];

        // Store in session
        session([
            'current_order_id' => $order->id,
            'order_summary'    => $orderSummary,
        ]);

        // Get cart count
        $cartCount = $this->getCartCount();

        // Get user data if logged in
        $user = Auth::user();

        return view('payment.options', compact('orderSummary', 'cartCount', 'user', 'order'));
    }

    private function handleSuccessfulPayment($order, $paymentData = [])
    {
        DB::beginTransaction();

        try {
            // Update order status and payment info
            $order->update([
                'status'         => 'processing',
                'payment_status' => 'paid',
                'payment_method' => $paymentData['method'] ?? 'unknown',
                'paid_amount'    => $order->total,
                'payment_date'   => now(),
                'is_paid'        => true,
            ]);

            // Update product stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $newQuantity               = $product->product_quantity - $item->quantity;
                    $product->product_quantity = max(0, $newQuantity);
                    $product->save();
                }
            }

            // Clear cart for this user/session
            $sessionId = session('cart_session_id');
            ProductAddCard::where(function ($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            // Clear cart count from session
            session(['cart_count' => 0]);

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling successful payment: ' . $e->getMessage());
            return false;
        }
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

        // Get order from session
        $orderId = session('current_order_id');
        if (! $orderId) {
            return redirect()->route('order.confirm')
                ->with('error', 'Please confirm your order first.');
        }

        $order = ConfirmOrder::with('items')->find($orderId);
        if (! $order) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }

        DB::beginTransaction();

        try {
            // Prepare line items for Stripe from order items
            $lineItems = [];

            foreach ($order->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'        => $item->product_title,
                            'description' => 'Quantity: ' . $item->quantity,
                        ],
                        'unit_amount'  => round($item->price * 100), // Convert to cents
                    ],
                    'quantity'   => $item->quantity,
                ];
            }

            // Add shipping as a line item
            if ($order->shipping > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Shipping Fee',
                        ],
                        'unit_amount'  => round($order->shipping * 100),
                    ],
                    'quantity'   => 1,
                ];
            }

            // Add tax as a line item
            if ($order->tax > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Tax (5%)',
                        ],
                        'unit_amount'  => round($order->tax * 100),
                    ],
                    'quantity'   => 1,
                ];
            }

            // Create Stripe Checkout Session
            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items'           => $lineItems,
                'mode'                 => 'payment',
                'success_url'          => route('payment.stripe.success', ['order_id' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('payment.stripe.cancel', ['order_id' => $order->id]),
                'customer_email'       => $order->email,
                'client_reference_id'  => $order->order_number,
                'metadata'             => [
                    'order_id'       => $order->id,
                    'order_number'   => $order->order_number,
                    'customer_name'  => $order->name,
                    'customer_email' => $order->email,
                ],
            ]);

            // Update order with Stripe session ID
            $order->update([
                'name'              => $validated['name'],
                'email'             => $validated['email'],
                'phone'             => $validated['phone'],
                'address'           => $validated['address'],
                'notes'             => $validated['notes'] ?? $order->notes,
                'stripe_session_id' => $checkoutSession->id,
                'payment_method'    => 'stripe',
                'payment_status'    => 'pending',
            ]);

            DB::commit();

            // Redirect to Stripe Checkout
            return redirect()->away($checkoutSession->url);

        } catch (\Exception $e) {
            DB::rollBack();

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
        DB::beginTransaction();

        try {
            $sessionId = $request->query('session_id');

            if (! $sessionId) {
                \Log::error('Stripe Success: No session_id provided', [
                    'order_id'     => $order_id,
                    'query_params' => $request->query(),
                ]);
                return redirect()->route('dashboard')
                    ->with('error', 'Invalid payment session. No session ID found.');
            }

            // Retrieve Stripe session
            try {
                $stripeSession = StripeSession::retrieve($sessionId);
                \Log::info('Stripe session retrieved', [
                    'session_id'          => $sessionId,
                    'payment_status'      => $stripeSession->payment_status,
                    'payment_intent'      => $stripeSession->payment_intent,
                    'amount_total'        => $stripeSession->amount_total,
                    'client_reference_id' => $stripeSession->client_reference_id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Stripe session retrieve error', [
                    'error'      => $e->getMessage(),
                    'session_id' => $sessionId,
                    'order_id'   => $order_id,
                ]);
                return redirect()->route('dashboard')
                    ->with('error', 'Failed to retrieve payment session. Please contact support.');
            }

            // Get order
            $order = ConfirmOrder::find($order_id);

            if (! $order) {
                \Log::error('Stripe Success: Order not found', [
                    'order_id'   => $order_id,
                    'session_id' => $sessionId,
                ]);
                return redirect()->route('dashboard')
                    ->with('error', 'Order not found.');
            }

            \Log::info('Order found for stripe success', [
                'order_id'           => $order->id,
                'order_number'       => $order->order_number,
                'stripe_session_id'  => $order->stripe_session_id,
                'request_session_id' => $sessionId,
                'payment_status'     => $order->payment_status,
            ]);

            // Update order with stripe session ID if not already set
            if (! $order->stripe_session_id) {
                $order->stripe_session_id = $sessionId;
            }

            // Check payment status from Stripe
            if ($stripeSession->payment_status === 'paid') {
                // Update order status
                $order->update([
                    'status'                   => 'processing',
                    'payment_status'           => 'paid',
                    'stripe_payment_intent_id' => $stripeSession->payment_intent,
                    'paid_amount'              => $stripeSession->amount_total / 100,
                    'payment_date'             => now(),
                    'stripe_session_id'        => $sessionId,
                    'is_paid'                  => true,
                ]);

                // Clear session
                Session::forget(['current_order_id', 'order_summary']);

                \Log::info('Stripe payment successful', [
                    'order_id'       => $order->id,
                    'order_number'   => $order->order_number,
                    'amount_paid'    => $stripeSession->amount_total / 100,
                    'payment_intent' => $stripeSession->payment_intent,
                ]);

                DB::commit();

                return view('payment.success', [
                    'order'          => $order,
                    'payment_method' => 'Stripe/Card',
                    'transaction_id' => $stripeSession->payment_intent,
                    'amount_paid'    => $stripeSession->amount_total / 100,
                ]);
            } else {
                // Payment not completed
                \Log::warning('Stripe payment not completed', [
                    'order_id'       => $order_id,
                    'payment_status' => $stripeSession->payment_status,
                ]);

                $order->update([
                    'payment_status'    => 'failed',
                    'stripe_session_id' => $sessionId,
                ]);

                DB::commit();

                return redirect()->route('payment.options')
                    ->with('error', 'Payment was not completed. Status: ' . $stripeSession->payment_status);
            }

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Stripe Success Error', [
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
                'order_id'   => $order_id,
                'session_id' => $request->query('session_id'),
            ]);

            return redirect()->route('dashboard')
                ->with('error', 'Error verifying payment: ' . $e->getMessage());
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
                    'payment_status' => 'cancelled',
                ]);
            }

            return redirect()->route('payment.options')
                ->with('error', 'Payment was cancelled. You can try again.');

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

        // Get order from session
        $orderId = session('current_order_id');
        if (! $orderId) {
            return redirect()->route('order.confirm')
                ->with('error', 'Please confirm your order first.');
        }

        $order = ConfirmOrder::find($orderId);
        if (! $order) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }

        DB::beginTransaction();

        try {
            // Update order details and mark as COD
            $order->update([
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'address'        => $validated['address'],
                'notes'          => $validated['notes'] ?? $order->notes,
                'payment_method' => 'cash_on_delivery',
                'payment_status' => 'pending',
                'status'         => 'pending',
            ]);

            DB::commit();

            // Clear session
            Session::forget(['current_order_id', 'order_summary']);

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

        // Get order from session
        $orderId = session('current_order_id');
        if (! $orderId) {
            return redirect()->route('order.confirm')
                ->with('error', 'Please confirm your order first.');
        }

        $order = ConfirmOrder::find($orderId);
        if (! $order) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }

        DB::beginTransaction();

        try {
            // Update order with mobile banking details
            $order->update([
                'name'                  => $validated['name'],
                'email'                 => $validated['email'],
                'phone'                 => $validated['phone'],
                'address'               => $validated['address'],
                'notes'                 => $validated['notes'] ?? $order->notes,
                'payment_method'        => 'mobile_banking',
                'payment_status'        => 'pending_verification',
                'status'                => 'pending',
                'mobile_banking_method' => $validated['mobile_banking_method'],
                'mobile_number'         => $validated['mobile_number'],
                'transaction_id'        => $validated['transaction_id'],
            ]);

            DB::commit();

            // Clear session
            Session::forget(['current_order_id', 'order_summary']);

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

        // Get order from session
        $orderId = session('current_order_id');
        if (! $orderId) {
            return redirect()->route('order.confirm')
                ->with('error', 'Please confirm your order first.');
        }

        $order = ConfirmOrder::find($orderId);
        if (! $order) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }

        DB::beginTransaction();

        try {
            // Update order with bank transfer details
            $order->update([
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'address'        => $validated['address'],
                'notes'          => $validated['notes'] ?? $order->notes,
                'payment_method' => 'bank_transfer',
                'payment_status' => 'pending_verification',
                'status'         => 'pending',
                'bank_name'      => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'transaction_id' => $validated['transaction_id'],
            ]);

            DB::commit();

            // Clear session
            Session::forget(['current_order_id', 'order_summary']);

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
        $payload         = $request->getContent();
        $sig_header      = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook.secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
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
                'is_paid'                  => true,
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
                'is_paid'        => true,
            ]);
        }
    }
}
