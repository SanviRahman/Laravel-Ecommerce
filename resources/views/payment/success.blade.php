<!DOCTYPE html>
<html>

<head>
    <!-- Same header as options.blade.php -->
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <title>Giftos - Payment Success</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Local Font Awesome -->
    <link rel="stylesheet" href="{{ asset('front_end/css/fontawesome/css/all.min.css') }}">

    <style>
    .payment-section {
        background-color: #f8f9fa;
        padding: 60px 0;
        min-height: 100vh;
    }

    .payment-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .payment-box {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }

    .payment-method {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }

    .payment-method.active {
        border-color: #007bff;
        background-color: #e7f1ff;
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-icon {
        font-size: 30px;
        margin-right: 15px;
        color: #666;
    }

    .payment-method.active .payment-icon {
        color: #007bff;
    }

    .stripe-icon {
        color: #635bff !important;
    }

    .bkash-icon {
        color: #e2136e !important;
    }

    .rocket-icon {
        color: #9c1d7a !important;
    }

    .nagad-icon {
        color: #e6131d !important;
    }

    .bank-icon {
        color: #28a745 !important;
    }

    .cod-icon {
        color: #dc3545 !important;
    }

    .order-summary {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .summary-total {
        font-size: 20px;
        font-weight: bold;
        color: #007bff;
    }

    .payment-details {
        display: none;
    }

    .payment-details.active {
        display: block;
    }

    .form-control {
        border-radius: 5px;
        padding: 10px 15px;
        border: 1px solid #ddd;
    }

    .btn-payment {
        background: #007bff;
        color: white;
        padding: 12px 30px;
        border-radius: 5px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-payment:hover {
        background: #0056b3;
    }

    .btn-payment:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }

    .back-link {
        color: #6c757d;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
    }

    .back-link:hover {
        color: #007bff;
    }

    .alert {
        border-radius: 5px;
    }

    /* Action Buttons */
    .action-buttons {
        margin-top: 40px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 25px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 8px;
        min-width: 180px;
        color: #fff;
    }

    /* Different Button Colors */
    .btn-home {
        background: #007bff;
    }

    .btn-track {
        background: #6c757d;
    }

    .btn-invoice {
        background: #28a745;
    }

    .btn-print {
        background: #17a2b8;
    }

    /* Hover Effect */
    .btn-action:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: #fff;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .btn-action {
            width: 100%;
            margin: 6px 0;
        }
    }
    </style>

    <!-- Include same CSS files -->
</head>

<body>
    <!-- header section -->
    <header class="header_section">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span>
                    Giftos
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  ">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">Cart Details</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('guest.track.order') }}" class="nav-link">
                            My Order
                        </a>
                    </li>
                </ul>
                <div class="user_option">
                    @if(Auth::check())
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                    @else
                    <a href="{{ route('login') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>
                            Login
                        </span>
                    </a>
                    <a href="{{ route('register') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>
                            Register
                        </span>
                    </a>
                    @endif
                    <a href="{{ route('cart.index') }}" class="cart-icon">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <!-- end header section -->

    <!-- Success Section -->
    <section class="success-section" style="padding: 100px 0; background: #f8f9fa; min-height: 70vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="success-box text-center"
                        style="background: white; padding: 50px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="success-icon mb-4">
                            <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                        </div>
                        <h2 class="mb-3">Payment Successful!</h2>
                        <p class="text-muted mb-4">Thank you for your order. We've received your payment.</p>

                        <div class="order-details mb-4" style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                            <h5 class="mb-3">Order Details</h5>
                            <div class="row text-left">
                                <div class="col-md-6">
                                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                    <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
                                    @if(isset($transaction_id))
                                    <p><strong>Transaction ID:</strong> {{ $transaction_id }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
                                    <p><strong>Status:</strong> <span class="badge badge-success">Payment
                                            Successful</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle"></i>
                            We've sent a confirmation email to <strong>{{ $order->email }}</strong> with your order
                            details.
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons text-center">
                            <a href="{{ url('/') }}" class="btn-action btn-home">
                                <i class="fas fa-home"></i> Back to Home
                            </a>
                            <a href="{{ route('guest.track.order') }}" class="btn-action btn-track">
                                <i class="fas fa-truck"></i> Track Order
                            </a>
                            <a href="{{ route('invoice.download', $order->order_number) }}"
                                class="btn-action btn-invoice" target="_blank">
                                <i class="fas fa-download"></i> Download Invoice
                            </a>
                            <a href="javascript:window.print()" class="btn-action btn-print">
                                <i class="fas fa-print"></i> Print Receipt
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- footer section -->
    <footer class="footer_section" style="background-color: #2c2c2c; color: white; padding: 20px 0;">
        <div class="container text-center">
            <p style="color: #aaa; margin: 0;">
                &copy; <span id="displayYear"></span> All Rights Reserved By
                <a href="https://html.design/" style="color: #f7444e; text-decoration: none;">Web Tech Knowledge</a>
            </p>
        </div>
    </footer>
    <!-- footer section -->

    <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>
</body>

</html>