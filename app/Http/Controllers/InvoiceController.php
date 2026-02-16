<?php

namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function download($order_number)
    {
        // অর্ডার খুঁজে বের করুন - order_number দিয়ে ConfirmOrder থেকে খুঁজুন
        $order = ConfirmOrder::where('order_number', $order_number)->firstOrFail();
        
        // অর্ডার আইটেমগুলো লোড করুন - order_id দিয়ে
        $order->load(['orderItems.product']);
        
        // চেক করুন যে ইউজার এই অর্ডার দেখার অনুমতি পাচ্ছে কিনা
        if (auth()->check()) {
            // Auth user - শুধু নিজের অর্ডার দেখতে পারবে
            if ($order->user_id != auth()->id()) {
                abort(403, 'Unauthorized access');
            }
        } else {
            // Guest user - সেশন থেকে ভেরিফাই করুন
            $guestOrderNumber = Session::get('guest_order_number');
            $guestEmail = Session::get('guest_email');
            
            if ($guestOrderNumber != $order->order_number) {
                abort(403, 'Unauthorized access');
            }
            
            // অপশনাল: ইমেইলও চেক করতে পারেন
            if ($guestEmail && $order->email != $guestEmail) {
                abort(403, 'Unauthorized access');
            }
        }
        
        // কোম্পানির তথ্য
        $companyInfo = [
            'name' => 'Giftos E-Commerce',
            'address' => '123, Main Street, Dhaka, Bangladesh',
            'phone' => '+880 1234 567890',
            'email' => 'info@giftos.com',
            'website' => 'www.giftos.com',
            'logo' => public_path('front_end/images/logo.png')
        ];
        
        // PDF জেনারেট করুন
        $pdf = Pdf::loadView('invoices.download', compact('order', 'companyInfo'));
        
        // PDF ডাউনলোড করুন
        return $pdf->download('invoice-'.$order->order_number.'.pdf');
    }
}