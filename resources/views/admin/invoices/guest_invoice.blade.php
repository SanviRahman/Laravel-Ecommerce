<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f7444e;
            padding-bottom: 20px;
        }
        .company-info h2 {
            color: #f7444e;
            margin: 0;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .bill-to, .invoice-info {
            width: 48%;
        }
        .section-title {
            color: #f7444e;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .summary {
            margin-top: 30px;
            border-top: 2px solid #f7444e;
            padding-top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #f7444e;
            border-top: 2px solid #f7444e;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 11px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h2>{{ config('app.name', 'Giftos') }}</h2>
                <p>123 Gift Street, Online Store</p>
                <p>Email: support@giftos.com | Phone: +1234567890</p>
                <p>Website: www.giftos.com</p>
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-{{ $order->payment_status }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Customer and Invoice Details -->
        <div class="details">
            <div class="bill-to">
                <div class="section-title">BILL TO</div>
                <p><strong>{{ $order->name }}</strong></p>
                <p>Email: {{ $order->email }}</p>
                <p>Phone: {{ $order->phone }}</p>
                <p>Address: {{ $order->address }}</p>
            </div>
            <div class="invoice-info">
                <div class="section-title">INVOICE DETAILS</div>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Customer Type:</strong> {{ ucfirst($order->customer_type) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="section-title">ORDER ITEMS</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th class="text-right">Price</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_title }}</td>
                    <td class="text-right">${{ number_format($item->price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Order Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span>${{ number_format($order->shipping, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Tax:</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="summary-row grand-total">
                <span>TOTAL AMOUNT:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <!-- Footer Notes -->
        <div class="footer">
            <p><strong>Thank you for your order!</strong></p>
            <p>If you have any questions about this invoice, please contact:</p>
            <p>Email: support@giftos.com | Phone: +1234567890</p>
            <p>This is a computer-generated invoice. No signature required.</p>
            <p>Invoice generated on: {{ now()->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>