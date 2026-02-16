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
        line-height: 1.4;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        background: #fff;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f7444e;
    }

    .logo h1 {
        color: #f7444e;
        margin: 0;
        font-size: 28px;
    }

    .logo p {
        margin: 5px 0 0;
        color: #666;
    }

    .invoice-title {
        text-align: right;
    }

    .invoice-title h2 {
        color: #f7444e;
        margin: 0;
        font-size: 24px;
    }

    .invoice-title p {
        margin: 5px 0 0;
    }

    .company-info,
    .customer-info {
        margin-bottom: 20px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 5px;
    }

    .company-info h3,
    .customer-info h3 {
        margin-top: 0;
        color: #f7444e;
        font-size: 16px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table th {
        background: #f7444e;
        color: white;
        padding: 10px;
        text-align: left;
        font-size: 12px;
    }

    table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    .totals {
        margin-top: 20px;
        text-align: right;
    }

    .totals table {
        width: 300px;
        margin-left: auto;
    }

    .totals td {
        padding: 5px 10px;
        border: none;
    }

    .totals .grand-total {
        font-weight: bold;
        font-size: 16px;
        color: #f7444e;
    }

    .footer {
        margin-top: 30px;
        padding-top: 20px;
        text-align: center;
        border-top: 1px solid #eee;
        color: #999;
        font-size: 11px;
    }

    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: bold;
    }

    .badge-success {
        background: #28a745;
        color: white;
    }

    .badge-warning {
        background: #ffc107;
        color: #333;
    }

    .badge-info {
        background: #17a2b8;
        color: white;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h1>Giftos</h1>
                <p>E-Commerce Store</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
            </div>
        </div>

        <!-- Company Info -->
        <div class="company-info">
            <h3>Company Information</h3>
            <table style="width: 100%; margin: 0;">
                <tr>
                    <td style="width: 50%; padding: 5px 0; border: none;">
                        <strong>{{ $companyInfo['name'] }}</strong><br>
                        {{ $companyInfo['address'] }}<br>
                        Phone: {{ $companyInfo['phone'] }}<br>
                        Email: {{ $companyInfo['email'] }}<br>
                        Web: {{ $companyInfo['website'] }}
                    </td>
                    <td style="width: 50%; padding: 5px 0; border: none; text-align: right;">
                        <strong>Payment Status:</strong><br>
                        @if($order->payment_status == 'paid')
                        <span class="badge badge-success">Paid</span>
                        @elseif($order->payment_status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                        @else
                        <span class="badge badge-info">{{ ucfirst($order->payment_status) }}</span>
                        @endif
                        <br><br>
                        <strong>Order Status:</strong><br>
                        <span class="badge badge-info">{{ ucfirst($order->order_status) }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Customer Info -->
        <div class="customer-info">
            <h3>Customer Information</h3>
            <table style="width: 100%; margin: 0;">
                <tr>
                    <td style="width: 50%; padding: 5px 0; border: none;">
                        <strong>Name:</strong> {{ $order->name }}<br>
                        <strong>Email:</strong> {{ $order->email }}<br>
                        <strong>Phone:</strong> {{ $order->phone }}<br>
                    </td>
                    <td style="width: 50%; padding: 5px 0; border: none;">
                        <strong>Address:</strong><br>
                        {{ $order->address }}<br>
                        @if($order->apartment)
                        {{ $order->apartment }}<br>
                        @endif
                        {{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}<br>
                        {{ $order->country }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Order Items Section -->
        <h3 style="margin-bottom: 10px;">Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        {{ $item->product_title }}<br>
                        @if($item->size)
                        <small>Size: {{ $item->size }}</small>
                        @endif
                    </td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if($order->discount > 0)
                <tr>
                    <td>Discount:</td>
                    <td>-${{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td>Shipping:</td>
                    <td>${{ number_format($order->shipping ?? 0, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Grand Total:</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Info -->
        @if($order->payment_method)
        <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
            <h3 style="margin: 0 0 10px; color: #f7444e;">Payment Information</h3>
            <p style="margin: 5px 0;">
                <strong>Payment Method:</strong> {{ $order->payment_method }}<br>
                @if($order->transaction_id)
                <strong>Transaction ID:</strong> {{ $order->transaction_id }}<br>
                @endif
                @if($order->mobile_number)
                <strong>Mobile Number:</strong> {{ $order->mobile_number }}<br>
                @endif
            </p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with Giftos!</p>
            <p>This is a computer generated invoice - no signature required.</p>
            <p>For any queries, please contact us at {{ $companyInfo['email'] }} or call {{ $companyInfo['phone'] }}</p>
        </div>
    </div>
</body>

</html>