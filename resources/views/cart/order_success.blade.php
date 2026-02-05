<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - {{ $order->order_number }}</title>
    <!-- Same styles as cart page -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }

    .success-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        font-size: 80px;
        color: #28a745;
        margin-bottom: 20px;
    }

    .order-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }

    .order-item {
        border-bottom: 1px solid #dee2e6;
        padding: 10px 0;
    }

    .print-btn {
        background: #2f3ad1;
        color: white;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    </style>
</head>

<body>
    <!-- Same header as cart page -->
    <div class="hero_area">
        <header class="header_section">
            <nav class="navbar navbar-expand-lg custom_nav-container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span>Giftos</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Why Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Testimonial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                    </ul>
                    <div class="user_option">
                        <a href="{{ route('cart.index') }}" class="cart-icon">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                            <span class="cart-count">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <div class="success-container">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="text-center">
                <i class="fas fa-check-circle success-icon"></i>
                <h1>Order Confirmed!</h1>
                <p class="lead">Thank you for your purchase. Your order has been placed successfully.</p>
            </div>

            <div class="order-details">
                <h4>Order Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Order Number:</strong></p>
                        <h4 class="text-primary">{{ $order->order_number }}</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><strong>Order Date:</strong></p>
                        <p>{{ $order->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Customer Details</h6>
                        <p><strong>Name:</strong> {{ $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Address:</strong> {{ $order->address }}</p>
                        @if($order->notes)
                        <p><strong>Notes:</strong> {{ $order->notes }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Order Status</h6>
                        <p><strong>Status:</strong>
                            <span class="badge badge-warning">{{ ucfirst($order->status) }}</span>
                        </p>
                        <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </p>
                        <p><strong>Payment Status:</strong>
                            <span class="badge badge-info">{{ ucfirst($order->payment_status) }}</span>
                        </p>
                    </div>
                </div>

                <hr>

                <h6>Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_title }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-8">
                        <h5>Order Summary</h5>
                    </div>
                    <div class="col-md-4 text-right">
                        <p>Subtotal: ${{ number_format($order->subtotal, 2) }}</p>
                        <p>Shipping: ${{ number_format($order->shipping, 2) }}</p>
                        <p>Tax: ${{ number_format($order->tax, 2) }}</p>
                        <h4>Total: ${{ number_format($order->total, 2) }}</h4>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <button onclick="window.print()" class="btn print-btn">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
            </div>

            <div class="alert alert-info mt-4">
                <h6><i class="fas fa-info-circle"></i> Important Information</h6>
                <p class="mb-1"><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p class="mb-1"><strong>Save this number</strong> for future reference and order tracking.</p>
                <p class="mb-0">You can track your order using your order number on our website.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Update cart count
    $(document).ready(function() {
        $.ajax({
            url: '{{ route("cart.count") }}',
            type: 'GET',
            success: function(data) {
                $('.cart-count').text(data.count || 0);
            }
        });
    });
    </script>
</body>

</html>