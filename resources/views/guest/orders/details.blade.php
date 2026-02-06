<!DOCTYPE html>
<html lang="en">

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

    <title>Order Details #{{ $order->order_number }} - {{ config('app.name') }}</title>

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

    <style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
        min-height: 100vh;
    }

    .order-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        padding: 40px;
        max-width: 1000px;
        margin: 50px auto;
    }

    .order-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .badge-status {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 500;
    }

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

    .order-item {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }

    .order-item:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .summary-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-top: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .summary-row.total {
        font-size: 1.2rem;
        font-weight: bold;
        color: #2c3e50;
        border-bottom: none;
        padding-top: 15px;
    }

    .action-buttons .btn {
        padding: 10px 20px;
        margin: 5px;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-print {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
        border: none;
    }

    .btn-invoice {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border: none;
    }

    .btn-back {
        background: #f7444e;
        color: white;
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .customer-info-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .customer-info-card h6 {
        color: #f7444e;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f7444e;
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #f7444e;
    }

    .timeline-item {
        position: relative;
        padding-left: 50px;
        margin-bottom: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #f7444e;
        border: 4px solid white;
        box-shadow: 0 0 0 2px #f7444e;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .order-card,
        .order-card * {
            visibility: visible;
        }

        .order-card {
            position: absolute;
            left: 0;
            top: 0;
            box-shadow: none;
            width: 100%;
        }

        .action-buttons {
            display: none !important;
        }
    }

    /* Consistent dimensions for all sections */
    .order-container,
    .contact_section,
    .info_section {
        width: 96%;
        border-radius: 10px;
        margin: 30px auto 40px;
    }

    .order-container {
        background-color: #d1c9c9;
        padding: 60px 0;
    }

    .contact_section {
        background-color: #d1c9c9;
        padding: 60px 0;
    }

    .info_section {
        background-color: #2c2c2c;
        padding: 60px 0 20px;
    }

    .btn-primary {
        background: #f7444e;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        border-radius: 25px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 68, 78, 0.3);
        background: #d43c45;
    }

    /* Common styles for all sections */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Contact section specific */
    .container-bg {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(63, 60, 60, 0.1);
        padding: 40px;
    }

    /* Map container */
    .map_container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .map-responsive {
        position: relative;
        overflow: hidden;
        padding-top: 75%;
    }

    /* Form styles */
    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 12px 15px;
        width: 100%;
    }

    .form-control:focus {
        outline: none;
        border-color: #f7444e;
        box-shadow: 0 0 0 2px rgba(247, 68, 78, 0.2);
    }

    /* Footer section */
    .footer_section {
        border-top: 1px solid #444;
        padding: 20px 0;
        margin-top: 40px;
    }

    /* Responsive design */
    @media (max-width: 991px) {

        .order-container,
        .contact_section,
        .info_section {
            padding: 40px 0 !important;
        }

        .container-bg {
            padding: 30px !important;
        }
    }

    @media (max-width: 767px) {

        .order-container,
        .contact_section,
        .info_section {
            padding: 30px 0 !important;
            width: 98%;
        }

        .container-bg {
            padding: 20px !important;
        }

        .order-card {
            padding: 20px;
            margin: 20px auto;
        }
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
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">Cart Details</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('guest.track.order') }}">
                                <span>Track Order</span>
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
                        <form class="form-inline ">
                            <button class="btn nav_search-btn" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <!-- end header section -->
    </div>
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
                                        <a href="#">
                                            Contact Us
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <div class="img-box">
                                        <img style="width:600px"
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


    <!-- Order Details Section -->
    <section class="order-container">
        <div class="container">
            <div class="order-card">
                <!-- Header -->
                <div class="order-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-2"><i class="fas fa-receipt me-2"></i> Order Details</h2>
                            <h4 class="text-primary mb-0">#{{ $order->order_number }}</h4>
                        </div>
                        <div class="text-end">
                            <div class="mb-2">
                                <span class="badge-status badge-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <small class="text-muted">{{ $order->created_at->format('F d, Y h:i A') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="customer-info-card">
                    <h6><i class="fas fa-user me-2"></i> Customer Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $order->name }}</p>
                            <p><strong>Email:</strong> {{ $order->email }}</p>
                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Shipping Address:</strong></p>
                            <p class="mb-0">{{ $order->address }}</p>
                            @if($order->notes)
                            <hr>
                            <p><strong>Order Notes:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <h5 class="mb-3"><i class="fas fa-history me-2"></i> Order Timeline</h5>
                <div class="timeline mb-4">
                    <div class="timeline-item">
                        <strong>Order Placed</strong>
                        <p class="text-muted mb-0">{{ $order->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    @if($order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered')
                    <div class="timeline-item">
                        <strong>Processing</strong>
                        <p class="text-muted mb-0">Order is being processed</p>
                    </div>
                    @endif
                    @if($order->status == 'shipped' || $order->status == 'delivered')
                    <div class="timeline-item">
                        <strong>Shipped</strong>
                        <p class="text-muted mb-0">Order has been shipped</p>
                    </div>
                    @endif
                    @if($order->status == 'delivered')
                    <div class="timeline-item">
                        <strong>Delivered</strong>
                        <p class="text-muted mb-0">Order has been delivered</p>
                    </div>
                    @endif
                </div>

                <!-- Order Items -->
                <h5 class="mb-3"><i class="fas fa-shopping-cart me-2"></i> Order Items</h5>
                <div class="mb-4">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                @if($item->product && $item->product->product_image)
                                <img src="{{ asset($item->product->product_image) }}" alt="{{ $item->product_title }}"
                                    class="product-image">
                                @else
                                <div class="product-image d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-box text-muted fa-2x"></i>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $item->product_title }}</h6>
                                @if($item->product)
                                <small class="text-muted">SKU: {{ $item->product->product_sku ?? 'N/A' }}</small>
                                @endif
                            </div>
                            <div class="col-md-2 text-center">
                                <p class="mb-0">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="col-md-2 text-end">
                                <p class="mb-0 fw-bold">${{ number_format($item->total, 2) }}</p>
                                <small class="text-muted">${{ number_format($item->price, 2) }} each</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="summary-card">
                    <h6 class="mb-3"><i class="fas fa-calculator me-2"></i> Order Summary</h6>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Amount</span>
                        <span class="text-primary">${{ number_format($order->total, 2) }}</span>
                    </div>

                    <!-- Payment Information -->
                    <div class="mt-4">
                        <p class="mb-1"><strong>Payment Method:</strong>
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                        <p class="mb-0"><strong>Payment Status:</strong>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons mt-4 text-center">
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print me-2"></i> Print Order
                    </button>
                    <a href="{{ route('guest.order.invoice', $order->order_number) }}" class="btn btn-invoice"
                        target="_blank">
                        <i class="fas fa-download me-2"></i> Download Invoice
                    </a>
                    <a href="{{ route('guest.track.order') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Track Another Order
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-back">
                        <i class="fas fa-home me-2"></i> Back to Home
                    </a>
                </div>

                <!-- Important Notes -->
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle me-2"></i> Important Information</h6>
                    <ul class="mb-0">
                        <li>Keep this order number for future reference: <strong>{{ $order->order_number }}</strong>
                        </li>
                        <li>Contact customer support if you have any questions</li>
                        <li>Expected delivery time: 3-5 business days</li>
                        <li>You can track your order anytime using your order number and email</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- contact section -->
    <section class="contact_section">
        <div class="container">
            <div class="heading_container text-center mb-5">
                <h2 style="color: #333; font-size: 36px; font-weight: 700;">
                    Contact Us
                </h2>
            </div>
            <div class="container-bg">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                        <div class="map_container">
                            <div class="map-responsive">
                                <iframe
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="contact_form">
                            <form action="#">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" placeholder="Your Phone">
                                </div>
                                <div class="form-group mb-3">
                                    <textarea class="form-control message-box" rows="4"
                                        placeholder="Your Message"></textarea>
                                </div>
                                <div class="d-flex">
                                    <button type="submit">
                                        SEND MESSAGE
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- info section -->
    <br><br>
    <section class="info_section">
        <div class="container">
            <div class="social_container text-center mb-4">
                <div class="social_box d-flex justify-content-center">
                    <a href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="info_container">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <h6>
                            ABOUT US
                        </h6>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                            consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="info_form">
                            <h5>
                                Newsletter
                            </h5>
                            <form action="#">
                                <div class="mb-3">
                                    <input type="email" placeholder="Enter your email">
                                </div>
                                <button type="submit">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <h6>
                            NEED HELP
                        </h6>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                            consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <h6>
                            CONTACT US
                        </h6>
                        <div class="info_link-box">
                            <a href="#">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>Gb road 123 london Uk</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>+01 12345678901</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>demo@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer section -->
        <footer class="footer_section">
            <div class="container text-center">
                <p>
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/">Web Tech Knowledge</a>
                </p>
            </div>
        </footer>
        <!-- footer section -->
    </section>

    <!-- Bootstrap JS and other scripts -->
    <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('front_end/js/custom.js') }}"></script>

    <script>
    // Display current year in footer
    document.getElementById('displayYear').textContent = new Date().getFullYear();

    // Print functionality
    function printOrder() {
        window.print();
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Update cart count
    function updateCartCount() {
        fetch('/cart/count', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.count || 0;
                    element.style.display = 'inline-block';
                });
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
            });
    }

    // Update cart count on page load
    updateCartCount();
    setInterval(updateCartCount, 30000);
    </script>
</body>

</html>