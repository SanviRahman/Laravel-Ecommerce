<!DOCTYPE html>
<html>

<head>
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

    <title>Giftos - Payment Options</title>

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

    /* Cart Items in Summary */
    .cart-items-summary {
        margin-top: 20px;
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
    }

    .cart-item-summary {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .cart-item-name {
        flex: 2;
        color: #333;
    }

    .cart-item-quantity {
        flex: 1;
        text-align: center;
        color: #666;
    }

    .cart-item-price {
        flex: 1;
        text-align: right;
        color: #333;
        font-weight: 500;
    }

    .summary-header {
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cart-item-summary {
            font-size: 13px;
        }

        .cart-item-name {
            flex: 1.5;
        }
    }
    </style>
</head>

<body>
    <!-- header section -->
    <header class="header_section" style="padding:0 40px">
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
                    <li class="nav-item">
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
    <!-- slider section -->
    <section class="slider_section" style="padding:0 40px">
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
                                        <p style="text-align: justify;">
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
                                        <img style="width:600px; border-radius: 10px;"
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

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="row mb-4">
        <div class="col-lg-8 offset-lg-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="row mb-4">
        <div class="col-lg-8 offset-lg-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i> Please fix the following errors:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="row mb-4">
        <div class="col-lg-8 offset-lg-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif
    <!-- Payment Section -->
    <section class="payment-section">
        <div class="container payment-container">
            <div class="row">
                <div class="col-lg-8">
                    <a href="{{ route('cart.index') }}" class="back-link">
                        <i class="fa fa-arrow-left"></i> Back to Cart
                    </a>

                    <div class="payment-box">
                        <h2 class="mb-4">Select Payment Method</h2>

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <!-- ফর্ম শুরু করুন এখানে -->
                        <form id="paymentForm" method="POST">
                            @csrf

                            <!-- Hidden field যোগ করুন -->
                            <input type="hidden" name="payment_method" id="payment_method_input">

                            <!-- Customer Information -->
                            <div class="mb-4">
                                <h4>Customer Information</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name *</label>
                                            <input type="text" name="name" class="form-control" required
                                                value="{{ Auth::user()->name ?? old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address *</label>
                                            <input type="email" name="email" class="form-control" required
                                                value="{{ Auth::user()->email ?? old('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="phone" class="form-control" required
                                                value="{{ Auth::user()->phone ?? old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Shipping Address *</label>
                                            <input type="text" name="address" class="form-control" required
                                                value="{{ Auth::user()->address ?? old('address') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Order Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mb-4">
                                <h4 class="mb-3">Choose Payment Method</h4>

                                <!-- Stripe/Card Payment -->
                                <label class="payment-method" for="stripe">
                                    <input type="radio" name="payment_method_radio" value="stripe" id="stripe">
                                    <div class="d-flex align-items-center">
                                        <i class="payment-icon fab fa-cc-stripe stripe-icon"></i>
                                        <div>
                                            <h5 class="mb-1">Credit/Debit Card (Stripe)</h5>
                                            <p class="mb-0 text-muted">Pay securely with your card</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Mobile Banking -->
                                <label class="payment-method" for="mobile_banking">
                                    <input type="radio" name="payment_method_radio" value="mobile_banking"
                                        id="mobile_banking">
                                    <div class="d-flex align-items-center">
                                        <i class="payment-icon fas fa-mobile-alt bkash-icon"></i>
                                        <div>
                                            <h5 class="mb-1">Mobile Banking</h5>
                                            <p class="mb-0 text-muted">bKash / Rocket / Nagad</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Bank Transfer -->
                                <label class="payment-method" for="bank_transfer">
                                    <input type="radio" name="payment_method_radio" value="bank_transfer"
                                        id="bank_transfer">
                                    <div class="d-flex align-items-center">
                                        <i class="payment-icon fas fa-university bank-icon"></i>
                                        <div>
                                            <h5 class="mb-1">Bank Transfer</h5>
                                            <p class="mb-0 text-muted">Direct bank transfer</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Cash on Delivery -->
                                <label class="payment-method" for="cod">
                                    <input type="radio" name="payment_method_radio" value="cod" id="cod">
                                    <div class="d-flex align-items-center">
                                        <i class="payment-icon fas fa-money-bill-wave cod-icon"></i>
                                        <div>
                                            <h5 class="mb-1">Cash on Delivery</h5>
                                            <p class="mb-0 text-muted">Pay when you receive</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Payment Details (Dynamic) -->
                            <div id="paymentDetails">
                                <!-- Mobile banking details -->
                                <div id="mobileBankingDetails" class="payment-details">
                                    <h5 class="mb-3">Mobile Banking Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Service *</label>
                                                <select name="mobile_banking_method" id="mobile_banking_method_select"
                                                    class="form-control">
                                                    <option value="">Choose Service</option>
                                                    <option value="BKash">BKash</option>
                                                    <option value="Rocket">DBBL Rocket</option>
                                                    <option value="Nagad">Nagad</option>
                                                </select>
                                                <div class="invalid-feedback" id="mobile_banking_method_error">
                                                    Please select a mobile banking service
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mobile Number *</label>
                                                <input type="text" name="mobile_number" id="mobile_number"
                                                    class="form-control" placeholder="01XXXXXXXXX"
                                                    value="{{ old('mobile_number') }}">
                                                <div class="invalid-feedback" id="mobile_number_error">
                                                    Please enter mobile number
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Transaction ID *</label>
                                        <input type="text" name="transaction_id" id="mobile_transaction_id"
                                            class="form-control" placeholder="Enter transaction ID"
                                            value="{{ old('transaction_id') }}">
                                        <div class="invalid-feedback" id="transaction_id_error">
                                            Please enter transaction ID
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <strong>Payment Instructions:</strong>
                                        <ol class="mb-0">
                                            <li>Send money to: <strong>017XXXXXXXX</strong></li>
                                            <li>Use your order number as reference</li>
                                            <li>Enter the transaction ID above</li>
                                        </ol>
                                    </div>
                                </div>

                                <!-- Bank transfer details -->
                                <div id="bankTransferDetails" class="payment-details">
                                    <h5 class="mb-3">Bank Transfer Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank Name *</label>
                                                <select name="bank_name" id="bank_name" class="form-control">
                                                    <option value="">Select Bank</option>
                                                    <option value="City Bank">City Bank</option>
                                                    <option value="Dutch Bangla Bank">Dutch Bangla Bank</option>
                                                    <option value="Brac Bank">Brac Bank</option>
                                                    <option value="Islami Bank">Islami Bank</option>
                                                    <option value="Sonali Bank">Sonali Bank</option>
                                                </select>
                                                <div class="invalid-feedback" id="bank_name_error">
                                                    Please select a bank
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Number *</label>
                                                <input type="text" name="account_number" id="account_number"
                                                    class="form-control" placeholder="Account number"
                                                    value="{{ old('account_number') }}">
                                                <div class="invalid-feedback" id="account_number_error">
                                                    Please enter account number
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Transaction ID *</label>
                                        <input type="text" name="bank_transaction_id" id="bank_transaction_id"
                                            class="form-control" placeholder="Enter transaction ID"
                                            value="{{ old('bank_transaction_id') }}">
                                        <div class="invalid-feedback" id="bank_transaction_id_error">
                                            Please enter transaction ID
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <strong>Bank Details:</strong>
                                        <ul class="mb-0">
                                            <li>Account Name: <strong>Your Company Name</strong></li>
                                            <li>Account Number: <strong>123456789</strong></li>
                                            <li>Bank: <strong>City Bank Limited</strong></li>
                                            <li>Branch: <strong>Gulshan Branch</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-primary" data-toggle="modal"
                                        data-target="#termsModal">Terms and Conditions</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="button" id="submitPayment" class="btn-payment" disabled>
                                Proceed to Payment
                            </button>
                        </form>
                        <!-- ফর্ম শেষ -->
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="col-lg-4">
                    <div class="payment-box">
                        <h4 class="mb-3">Order Summary</h4>
                        <div class="order-summary">
                            <!-- Show order details instead of cart items -->
                            @if(isset($order) && $order)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Order Number:</span>
                                    <strong>{{ $order->order_number }}</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Order Status:</span>
                                    <span class="badge badge-warning">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Payment Status:</span>
                                    <span class="badge badge-info">{{ ucfirst($order->payment_status) }}</span>
                                </div>
                            </div>
                            @endif

                            <!-- Summary Totals -->
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span>${{ number_format($orderSummary['subtotal'] ?? 0, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Shipping</span>
                                <span>${{ number_format($orderSummary['shipping'] ?? 0, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Tax (5%)</span>
                                <span>${{ number_format($orderSummary['tax'] ?? 0, 2) }}</span>
                            </div>
                            <div class="summary-item summary-total">
                                <span>Total</span>
                                <span>${{ number_format($orderSummary['total'] ?? 0, 2) }}</span>
                            </div>

                            <!-- Order ID -->
                            <div class="summary-item mt-3">
                                <span>Order ID</span>
                                <span class="badge badge-secondary">#{{ $orderSummary['order_id'] ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="mt-4">
                            <h5>Payment Instructions</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check text-success"></i> Complete payment to confirm order</li>
                                <li><i class="fa fa-check text-success"></i> Get instant confirmation</li>
                                <li><i class="fa fa-check text-success"></i> Secure payment processing</li>
                                <li><i class="fa fa-check text-success"></i> 24/7 customer support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>1. Order Acceptance</h6>
                    <p>Your receipt of an electronic or other form of order confirmation does not signify our acceptance
                        of your order, nor does it constitute confirmation of our offer to sell.</p>

                    <h6>2. Pricing</h6>
                    <p>Prices are subject to change without notice. We reserve the right to modify or discontinue
                        products without notice at any time.</p>

                    <h6>3. Shipping Policy</h6>
                    <p>Shipping costs are calculated based on weight and destination. Delivery times are estimates and
                        not guaranteed.</p>

                    <h6>4. Returns & Refunds</h6>
                    <p>We accept returns within 30 days of delivery. Items must be in original condition with tags
                        attached.</p>

                    <h6>5. Privacy Policy</h6>
                    <p>We respect your privacy and are committed to protecting your personal information.</p>

                    <h6>6. Payment Security</h6>
                    <p>All payments are processed securely through encrypted connections.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">I Understand</button>
                </div>
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


    <!-- footer section -->

    <!-- info section -->

    <br><br>
    <section class="info_section layout_padding2-top"
        style="background-color: #2c2c2c; color: white; padding: 60px 0 20px;">
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
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
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
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
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

    <style>
    /* Common Styles for Both Sections */
    .contact_section,
    .info_section {
        width: 96%;
        border-radius: 10px;
        margin: 0 auto 40px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Form Controls */
    .form-control:focus {
        outline: none;
        border-color: #f7444e;
        box-shadow: 0 0 0 2px rgba(247, 68, 78, 0.2);
    }

    /* Button Hover Effects */
    button:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    /* Social Icons Hover */
    .social_box a:hover {
        color: #f7444e !important;
        transform: scale(1.1);
        transition: all 0.3s ease;
    }

    /* Links Hover */
    .info_link-box a:hover {
        color: #f7444e !important;
        transition: color 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 991px) {

        .contact_section,
        .info_section {
            padding: 40px 0 !important;
        }

        .container-bg {
            padding: 30px !important;
        }

        .col-md-6,
        .col-lg-3 {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 767px) {

        .contact_section,
        .info_section {
            padding: 30px 0 !important;
        }

        .container-bg {
            padding: 20px !important;
        }

        .heading_container h2 {
            font-size: 28px !important;
        }

        .social_box a {
            margin: 0 10px !important;
            font-size: 20px !important;
        }
    }

    /* Font Awesome Fix */
    .fab,
    .fa {
        font-family: 'Font Awesome 6 Brands', 'Font Awesome 6 Free' !important;
    }
    </style>

    <!-- JavaScript Files -->
    <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>

    <!-- Custom JavaScript -->
    <script>
    $(document).ready(function() {
        // Set current year
        $('#displayYear').text(new Date().getFullYear());

        // Payment method selection
        $('.payment-method').click(function() {
            $('.payment-method').removeClass('active');
            $(this).addClass('active');

            // Uncheck all radio buttons first
            $('input[name="payment_method_radio"]').prop('checked', false);

            // Check the selected one
            $(this).find('input').prop('checked', true);

            // Get selected payment method value
            const paymentMethod = $(this).find('input').val();

            // Set the hidden input value
            $('#payment_method_input').val(paymentMethod);

            // Hide all payment details
            $('.payment-details').removeClass('active').hide();
            $('.payment-details input, .payment-details select').prop('required', false);

            // Show relevant payment details
            if (paymentMethod === 'mobile_banking') {
                $('#mobileBankingDetails').addClass('active').show();
                $('#mobileBankingDetails select, #mobileBankingDetails input').prop('required', true);
            } else if (paymentMethod === 'bank_transfer') {
                $('#bankTransferDetails').addClass('active').show();
                $('#bankTransferDetails select, #bankTransferDetails input').prop('required', true);
            }

            // Update submit button text
            let buttonText = 'Proceed to Payment';
            if (paymentMethod === 'cod') {
                buttonText = 'Place Order (Cash on Delivery)';
            } else if (paymentMethod === 'stripe') {
                buttonText = 'Pay with Card';
            } else if (paymentMethod === 'mobile_banking') {
                buttonText = 'Confirm Mobile Banking Payment';
            } else if (paymentMethod === 'bank_transfer') {
                buttonText = 'Confirm Bank Transfer';
            }

            $('#submitPayment').text(buttonText).prop('disabled', false);

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').hide();
        });

        // Terms checkbox
        $('#terms').change(function() {
            if ($(this).is(':checked') && $('input[name="payment_method_radio"]:checked').length > 0) {
                $('#submitPayment').prop('disabled', false);
            } else {
                $('#submitPayment').prop('disabled', true);
            }
        });

        // Form submission - FIXED: Proper POST method handling
        $('#submitPayment').click(function(e) {
            e.preventDefault();

            // Reset validation
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').hide();

            let isValid = true;

            // Check terms
            if (!$('#terms').is(':checked')) {
                alert('Please agree to the terms and conditions.');
                return;
            }

            const paymentMethod = $('input[name="payment_method_radio"]:checked').val();

            if (!paymentMethod) {
                alert('Please select a payment method.');
                return;
            }

            // Ensure hidden input has value
            $('#payment_method_input').val(paymentMethod);

            // Client-side validation for mobile banking
            if (paymentMethod === 'mobile_banking') {
                const mobileMethod = $('#mobile_banking_method_select').val();
                const mobileNumber = $('#mobile_number').val().trim();
                const transactionId = $('#mobile_transaction_id').val().trim();

                if (!mobileMethod) {
                    $('#mobile_banking_method_select').addClass('is-invalid');
                    $('#mobile_banking_method_error').show();
                    isValid = false;
                }

                if (!mobileNumber) {
                    $('#mobile_number').addClass('is-invalid');
                    $('#mobile_number_error').show();
                    isValid = false;
                } else if (!/^01[3-9]\d{8}$/.test(mobileNumber)) {
                    $('#mobile_number').addClass('is-invalid');
                    $('#mobile_number_error').text(
                        'Please enter a valid Bangladeshi mobile number (e.g., 01712345678)').show();
                    isValid = false;
                }

                if (!transactionId) {
                    $('#mobile_transaction_id').addClass('is-invalid');
                    $('#transaction_id_error').show();
                    isValid = false;
                }
            }

            // Client-side validation for bank transfer
            if (paymentMethod === 'bank_transfer') {
                const bankName = $('#bank_name').val();
                const accountNumber = $('#account_number').val().trim();
                const transactionId = $('#bank_transaction_id').val().trim();

                if (!bankName) {
                    $('#bank_name').addClass('is-invalid');
                    $('#bank_name_error').show();
                    isValid = false;
                }

                if (!accountNumber) {
                    $('#account_number').addClass('is-invalid');
                    $('#account_number_error').show();
                    isValid = false;
                }

                if (!transactionId) {
                    $('#bank_transaction_id').addClass('is-invalid');
                    $('#bank_transaction_id_error').show();
                    isValid = false;
                }
            }

            if (!isValid) {
                // Scroll to first error
                $('.is-invalid').first().focus();
                return;
            }

            // Set form action and method based on payment method - FIXED HERE
            const form = $('#paymentForm');

            if (paymentMethod === 'stripe') {
                form.attr('action', '{{ route("payment.stripe") }}');
            } else if (paymentMethod === 'cod') {
                form.attr('action', '{{ route("payment.cod") }}');
            } else if (paymentMethod === 'mobile_banking') {
                form.attr('action', '{{ route("payment.mobile.banking") }}');
            } else if (paymentMethod === 'bank_transfer') {
                form.attr('action', '{{ route("payment.bank.transfer") }}');
            }

            // Make sure method is POST - IMPORTANT FIX
            form.attr('method', 'POST');

            // Debug: Check form attributes (remove in production)
            console.log('Form action:', form.attr('action'));
            console.log('Form method:', form.attr('method'));
            console.log('Payment method:', paymentMethod);

            // Submit the form
            form.submit();
        });

        // Auto-fill user data if logged in
        @if(Auth::check())
        const userPhone = "{{ Auth::user()->phone }}";
        const userAddress = "{{ Auth::user()->address }}";

        if (userPhone && userPhone !== '') {
            $('input[name="phone"]').val(userPhone);
        }
        if (userAddress && userAddress !== '') {
            $('input[name="address"]').val(userAddress);
        }
        @endif

        // Fill old input values if any
        @if(old('mobile_banking_method'))
        $('#mobile_banking_method_select').val("{{ old('mobile_banking_method') }}");
        @endif

        @if(old('mobile_number'))
        $('#mobile_number').val("{{ old('mobile_number') }}");
        @endif

        @if(old('transaction_id'))
        $('#mobile_transaction_id').val("{{ old('transaction_id') }}");
        @endif

        @if(old('bank_name'))
        $('#bank_name').val("{{ old('bank_name') }}");
        @endif

        @if(old('account_number'))
        $('#account_number').val("{{ old('account_number') }}");
        @endif

        @if(old('bank_transaction_id'))
        $('#bank_transaction_id').val("{{ old('bank_transaction_id') }}");
        @endif

        // Auto select first payment method
        $('.payment-method:first').click();

        // If there are old inputs, select the appropriate payment method
        @if(old('payment_method') == 'mobile_banking')
        $('input[value="mobile_banking"]').closest('.payment-method').click();
        @elseif(old('payment_method') == 'bank_transfer')
        $('input[value="bank_transfer"]').closest('.payment-method').click();
        @elseif(old('payment_method') == 'stripe')
        $('input[value="stripe"]').closest('.payment-method').click();
        @elseif(old('payment_method') == 'cod')
        $('input[value="cod"]').closest('.payment-method').click();
        @endif

        // Initialize all payment details as hidden
        $('.payment-details').hide();

        // Real-time form validation
        $('input, select').on('blur', function() {
            const paymentMethod = $('input[name="payment_method_radio"]:checked').val();
            const fieldName = $(this).attr('name');

            if (paymentMethod === 'mobile_banking') {
                if (fieldName === 'mobile_number') {
                    const value = $(this).val().trim();
                    if (value && !/^01[3-9]\d{8}$/.test(value)) {
                        $(this).addClass('is-invalid');
                        $('#mobile_number_error').text('Please enter a valid Bangladeshi mobile number')
                            .show();
                    } else {
                        $(this).removeClass('is-invalid');
                        $('#mobile_number_error').hide();
                    }
                }
            }
        });

        // Also make sure the form itself has proper method attribute
        $('#paymentForm').attr('method', 'POST');
    });
    </script>

</body>

</html>