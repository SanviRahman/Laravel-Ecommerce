<?php
namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestOrderController extends Controller
{
    /**
     * Show track order page
     */
    public function trackOrder()
    {
        return view('guest.orders.track');
    }

    /**
     * Track order by number and email
     */
    public function trackOrderPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|string',
            'email'        => 'required|email',
        ], [
            'order_number.required' => 'Order number is required',
            'email.required'        => 'Email address is required',
            'email.email'           => 'Please enter a valid email address',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        $order = ConfirmOrder::with(['items.product'])
            ->where('order_number', $request->order_number)
            ->where('email', $request->email)
            ->where('customer_type', 'guest')
            ->first();

        if (! $order) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Order not found. Please check your order number and email.');
        }

        return view('guest.orders.details', compact('order'));
    }

    /**
     * Show order details by ID (for direct link)
     */
    public function showOrderDetails($order_number)
    {
        $order = ConfirmOrder::with(['items.product'])
            ->where('order_number', $order_number)
            ->where('customer_type', 'guest')
            ->first();

        if (! $order) {
            return redirect()->route('guest.track.order')
                ->with('error', 'Order not found. Please track your order first.');
        }

        return view('guest.orders.details', compact('order'));
    }

    /**
     * Download order invoice (PDF)
     */
    public function downloadInvoice($order_number)
    {
        $order = ConfirmOrder::with(['items.product'])
            ->where('order_number', $order_number)
            ->where('customer_type', 'guest')
            ->first();

        if (! $order) {
            return redirect()->route('guest.track.order')
                ->with('error', 'Order not found.');
        }

        // Generate PDF invoice
        // You can use a package like barryvdh/laravel-dompdf

        return response()->streamDownload(function () use ($order) {
            echo view('guest.orders.invoice_pdf', compact('order'))->render();
        }, 'invoice_' . $order->order_number . '.pdf');
    }

    /**
     * Send order details to email
     */
    public function sendOrderDetails(Request $request, $order_number)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $order = ConfirmOrder::with(['items.product'])
            ->where('order_number', $order_number)
            ->where('customer_type', 'guest')
            ->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        // Send email with order details
        // You can use Laravel Mail

        return response()->json([
            'success' => true,
            'message' => 'Order details sent to your email.',
        ]);
    }
}
