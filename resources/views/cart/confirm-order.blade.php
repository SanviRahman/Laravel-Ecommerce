<!DOCTYPE html>
<html>

<head>
    <title>Confirm Order</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <!-- Bootstrap 4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

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


    <!-- Custom CSS -->
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }

    /* Navbar Mobile Fix */
    .navbar-toggler {
        border: 1px solid #2f3ad1;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 51, 104, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav {
            flex-direction: column;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            padding: 10px 15px;
            border-radius: 5px;
        }

        .nav-link:hover {
            background: #ff3368;
            color: white !important;
        }

        .user_option {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
    }

    /* Confirm Order Page Styles */
    .container.mt-5 {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 400px);
    }

    .container.mt-5 h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 700;
        color: #333;
    }

    .container.mt-5 .row {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .container.mt-5 .col-md-8 {
        float: none;
        margin: 0 auto;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #2f3ad1, #4a5de0);
        color: white;
        border-bottom: none;
        padding: 20px;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 22px;
    }

    .card-body {
        padding: 30px;
    }

    /* Form Styling */
    .form-group label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #4a5de0;
        box-shadow: 0 0 0 0.2rem rgba(74, 93, 224, 0.25);
    }

    /* Order Summary */
    .d-flex.justify-content-between {
        padding: 8px 0;
    }

    .font-weight-bold {
        font-size: 18px;
        color: #333;
    }

    /* Buttons */
    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2f3ad1, #4a5de0);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(47, 58, 209, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    /* Terms Checkbox */
    .form-check {
        margin: 25px 0;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 0.25rem;
    }

    .form-check-label {
        margin-left: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container.mt-5 {
            padding: 20px;
        }

        .container.mt-5 .col-md-8 {
            width: 100%;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            text-align: center;
        }
    }


    /* Cart Page Styles */
    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .cart-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .cart-header h1 {
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .cart-header p {
        color: #666;
    }

    .cart-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        margin-bottom: 30px;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-cart i {
        font-size: 80px;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: #666;
        margin-bottom: 15px;
    }

    .empty-cart p {
        color: #999;
        margin-bottom: 25px;
    }

    /* Cart Items Table */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table thead th {
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #eee;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
    }

    .cart-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-table tbody tr:hover {
        background-color: #fafafa;
    }

    .cart-table td {
        padding: 20px 15px;
        vertical-align: middle;
    }

    .product-info {
        display: flex;
        align-items: center;
    }

    .product-image {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
        margin-right: 20px;
        border: 1px solid #eee;
    }

    .product-details h4 {
        margin: 0 0 5px 0;
        font-size: 18px;
        color: #333;
    }

    .product-details p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .price {
        font-weight: 600;
        color: #333;
        font-size: 18px;
    }

    /* Quantity Control */
    .quantity-control {
        display: flex;
        align-items: center;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        user-select: none;
    }

    .quantity-btn:hover {
        background: #e9ecef;
    }

    .quantity-btn:active {
        background: #dee2e6;
    }

    .quantity-input {
        width: 50px;
        height: 35px;
        text-align: center;
        border: 1px solid #ddd;
        border-left: none;
        border-right: none;
        font-size: 16px;
        font-weight: 500;
    }

    /* Remove Button */
    .remove-btn {
        background: none;
        border: none;
        color: #ff3368;
        cursor: pointer;
        font-size: 18px;
        padding: 5px;
        transition: color 0.3s;
    }

    .remove-btn:hover {
        color: #d32f5a;
    }

    /* Cart Summary */
    .cart-summary {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .summary-row.total {
        font-size: 20px;
        font-weight: 700;
        color: #333;
    }

    .summary-value {
        font-weight: 600;
        color: #333;
    }

    .checkout-btn {
        background: linear-gradient(135deg, #2f3ad1, #4a5de0);
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(47, 58, 209, 0.3);
    }

    .checkout-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Continue Shopping Button */
    .continue-btn {
        background: white;
        color: #333;
        border: 2px solid #ddd;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        font-weight: 600;
        transition: all 0.3s;
    }

    .continue-btn:hover {
        background: #f8f9fa;
        color: #333;
        text-decoration: none;
        border-color: #ccc;
    }

    /* Customer Information Form Styles */
    .customer-info-form {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #eee;
        margin-top: 20px;
    }

    .customer-info-form h5 {
        color: #333;
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .customer-info-form .form-group {
        margin-bottom: 15px;
    }

    .customer-info-form label {
        font-weight: 500;
        color: #555;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .customer-info-form .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
    }

    .customer-info-form .form-control:focus {
        border-color: #4a5de0;
        box-shadow: 0 0 0 0.2rem rgba(74, 93, 224, 0.25);
    }

    .customer-info-form textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .customer-info-form .form-check-label {
        font-size: 13px;
        color: #666;
    }

    .customer-info-form .form-check-input {
        margin-top: 0.25rem;
    }

    /* Terms Modal */
    .terms-modal .modal-content {
        border-radius: 10px;
    }

    .terms-modal .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
    }

    .terms-modal .modal-body {
        max-height: 400px;
        overflow-y: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cart-table thead {
            display: none;
        }

        .cart-table tbody tr {
            display: block;
            margin-bottom: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 15px;
        }

        .cart-table td {
            display: block;
            text-align: right;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }

        .cart-table td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            color: #666;
        }

        .cart-table td:last-child {
            border-bottom: none;
        }

        .product-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-image {
            width: 80px;
            height: 80px;
            margin-right: 0;
            margin-bottom: 10px;
        }

        .quantity-control {
            justify-content: flex-end;
        }

        .customer-info-form {
            padding: 15px;
        }
    }

    /* Cart count badge */
    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ff3368;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-icon {
        position: relative;
    }

    /* Loading spinner */
    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Status Badges */
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-processing {
        background-color: #17a2b8;
        color: white;
    }

    .badge-shipped {
        background-color: #007bff;
        color: white;
    }

    .badge-delivered {
        background-color: #28a745;
        color: white;
    }

    .badge-cancelled {
        background-color: #dc3545;
        color: white;
    }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span>
                        Giftos
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class=""></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav  ">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('cart.index') }}">Cart Details</a>
                        </li>
                        <li>
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
                    </div>
                </div>
            </nav>
        </header>
        <!-- end header section -->
        <!-- slider section -->
        <section class="slider_section">
            <div class="slider_container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="detail-box">
                                            <h1>
                                                Welcome To Our <br>
                                                Gift Shop
                                            </h1>
                                            <p>
                                                Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non
                                                necessitatibus error distinctio mollitia suscipit. Nostrum fugit
                                                doloribus consequatur distinctio esse, possimus maiores aliquid repellat
                                                beatae cum, perspiciatis enim, accusantium perferendis.
                                            </p>
                                            <a href="{{ route('contact') }}">
                                                Contact Us
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="img-box">
                                            <img style="width:600px;border-radius:10px;"
                                                src="https://cdn.pixabay.com/photo/2021/11/22/20/20/online-6817350_1280.jpg"
                                                alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <!-- end slider section -->
    </div>
    <div class="container mt-5">
        <h2>Confirm Your Order</h2>

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="{{ route('cart.confirm.process') }}">
                    @csrf

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Shipping Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name *</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name ?? old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address *</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ Auth::user()->email ?? old('email') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number *</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ Auth::user()->phone ?? old('phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shipping Address *</label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ Auth::user()->address ?? old('address') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Order Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Order Summary</h4>
                        </div>
                        <div class="card-body">
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    {{ $item['product_title'] }} × {{ $item['quantity'] }}
                                </div>
                                <div>${{ number_format($item['total'], 2) }}</div>
                            </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between">
                                <div>Subtotal:</div>
                                <div>${{ number_format($subtotal, 2) }}</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>Shipping:</div>
                                <div>${{ number_format($shipping, 2) }}</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>Tax:</div>
                                <div>${{ number_format($tax, 2) }}</div>
                            </div>
                            <div class="d-flex justify-content-between font-weight-bold">
                                <div>Total:</div>
                                <div>${{ number_format($total, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and
                                Conditions</a>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Confirm Order & Proceed to Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- contact section -->
    <section class="contact_section" style="background-color: #f8f9fa; padding: 60px 0; height: auto;">
        <div class="container">
            <div class="heading_container text-center mb-5">
                <h2 style="color: #333; font-size: 36px; font-weight: 700;">
                    Contact Us
                </h2>
                <p class="text-muted">We'd love to hear from you. Send us a message and we'll respond as soon as
                    possible.</p>
            </div>

            <div class="container-bg"
                style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(63, 60, 60, 0.1); padding: 40px;">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                        <div class="map_container"
                            style="border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                            <div class="map-responsive" style="position: relative; overflow: hidden; padding-top: 75%;">
                                <iframe
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <div class="contact-info mt-4">
                            <h5 style="color: #333; font-weight: 600; margin-bottom: 15px;">
                                <i class="fa fa-info-circle"></i> Contact Information
                            </h5>
                            <div class="info-item mb-2">
                                <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                                <span>123 Main Street, Dhaka, Bangladesh</span>
                            </div>
                            <div class="info-item mb-2">
                                <i class="fa fa-phone text-primary mr-2"></i>
                                <span>+880 1234 567890</span>
                            </div>
                            <div class="info-item mb-2">
                                <i class="fa fa-envelope text-primary mr-2"></i>
                                <span>info@giftos.com</span>
                            </div>
                            <div class="info-item">
                                <i class="fa fa-clock text-primary mr-2"></i>
                                <span>Mon - Fri: 9:00 AM - 6:00 PM</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="contact_form" style="padding: 20px;">
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Your Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter your full name"
                                        value="{{ old('name') }}" required
                                        style="border: 1px solid #ddd; border-radius: 5px; padding: 12px 15px; width: 100%;">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="your@email.com" value="{{ old('email') }}"
                                        required
                                        style="border: 1px solid #ddd; border-radius: 5px; padding: 12px 15px; width: 100%;">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="+880 1234 567890"
                                        value="{{ old('phone') }}"
                                        style="border: 1px solid #ddd; border-radius: 5px; padding: 12px 15px; width: 100%;">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="subject" class="form-label">Subject (Optional)</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                        id="subject" name="subject" placeholder="What is this regarding?"
                                        value="{{ old('subject') }}"
                                        style="border: 1px solid #ddd; border-radius: 5px; padding: 12px 15px; width: 100%;">
                                    @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="message" class="form-label">Your Message *</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                        name="message" rows="4" placeholder="Please enter your message here..." required
                                        style="border: 1px solid #ddd; border-radius: 5px; padding: 12px 15px; width: 100%; resize: vertical;">{{ old('message') }}</textarea>
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="d-flex">
                                    <button type="submit"
                                        style="background: #333; color: white; border: none; padding: 12px 35px; border-radius: 5px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
                                        <i class="fa fa-paper-plane"></i> SEND MESSAGE
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <br><br>
    <section class="info_section layout_padding2-top"
        style="background-color: #2c2c2c; color: white; padding: 60px 0 20px; border-radius: 10px;">
        <div class="container">
            <div class="social_container text-center mb-4">
                <div class="social_box d-flex justify-content-center">
                    <a href="#" style="color: white; margin: 0 15px; font-size: 24px; text-decoration: none;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" style="color: white; margin: 0 15px; font-size: 24px; text-decoration: none;">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" style="color: white; margin: 0 15px; font-size: 24px; text-decoration: none;">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" style="color: white; margin: 0 15px; font-size: 24px; text-decoration: none;">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="info_container" style="padding: 40px 0;">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <h6 style="color: #fff; font-size: 20px; font-weight: 600; margin-bottom: 20px;">
                            ABOUT US
                        </h6>
                        <p style="color: #aaa; line-height: 1.6;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit
                            amet,
                            consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="info_form">
                            <h5 style="color: #fff; font-size: 20px; font-weight: 600; margin-bottom: 20px;">
                                Newsletter
                            </h5>
                            <form action="#">
                                <div class="mb-3">
                                    <input type="email" placeholder="Enter your email"
                                        style="border: 1px solid #555; background: #444; color: white; border-radius: 5px; padding: 10px 15px; width: 100%;">
                                </div>
                                <button type="submit"
                                    style="background: #f7444e; color: white; border: none; padding: 10px 25px; border-radius: 5px; cursor: pointer;">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <h6 style="color: #fff; font-size: 20px; font-weight: 600; margin-bottom: 20px;">
                            NEED HELP
                        </h6>
                        <p style="color: #aaa; line-height: 1.6;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit
                            amet,
                            consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <h6 style="color: #fff; font-size: 20px; font-weight: 600; margin-bottom: 20px;">
                            CONTACT US
                        </h6>
                        <div class="info_link-box">
                            <a href="#"
                                style="color: #aaa; text-decoration: none; display: block; margin-bottom: 10px;">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span style="margin-left: 10px;">Gb road 123 london Uk</span>
                            </a>
                            <a href="#"
                                style="color: #aaa; text-decoration: none; display: block; margin-bottom: 10px;">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span style="margin-left: 10px;">+01 12345678901</span>
                            </a>
                            <a href="#" style="color: #aaa; text-decoration: none; display: block;">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span style="margin-left: 10px;">demo@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer section -->
        <footer class="footer_section" style="border-top: 1px solid #444; padding: 20px 0; margin-top: 40px;">
            <div class="container text-center">
                <p style="color: #aaa; width: fit-content; margin: 0 auto; text-align: center;">
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/" style="color: #f7444e; text-decoration: none;">
                        Web Tech Knowledge
                    </a>
                </p>

            </div>
        </footer>
        <!-- footer section -->
    </section>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>