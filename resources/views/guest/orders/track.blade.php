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

    <title>Track Your Order - {{ config('app.name') }}</title>

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
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    /* ========== HEADER & HERO AREA ========== */
    .hero_area {
        min-height: auto;
        position: relative;
    }

    .slider_section {
        position: relative;
        width: 100%;
        margin: 0;
        padding: 0 44px;
    }

    .slider_container {
        position: relative;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .carousel {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .carousel-inner {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .carousel-item {
        width: 100%;
        margin: 0;
        padding: 0;
        height: 500px;
    }

    .container-fluid {
        padding: 0;
        margin: 0;
        width: 100%;
        height: 100%;
    }

    .row {
        margin: 0;
        width: 100%;
        height: 100%;
        align-items: center;
    }

    .detail-box {
        padding: 20px;
        width: 100%;
    }

    .detail-box h1 {
        font-size: 48px;
        font-weight: 700;
        color: white;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .detail-box p {
        font-size: 16px;
        color: white;
        line-height: 1.6;
        margin-bottom: 30px;
        max-width: 90%;
    }

    .detail-box a {
        display: inline-block;
        padding: 12px 35px;
        background: #f7444e;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .detail-box a:hover {
        background: #d43c45;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 68, 78, 0.3);
    }

    .img-box {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        width: 100%;
        height: 100%;
    }

    /* Important: Make exactly same as index.blade.php */
    .img-box img {
        width: 100%;
        max-width: 600px;
        height: auto;
        max-height: 400px;
        border-radius: 15px;
        object-fit: cover;
    }

    /* ========== TRACK ORDER SECTION ========== */
    .track-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
        max-width: 600px;
        margin: 50px auto;
    }

    .track-icon {
        font-size: 4rem;
        color: #f7444e;
        margin-bottom: 20px;
    }

    .form-control:focus {
        border-color: #f7444e;
        box-shadow: 0 0 0 0.2rem rgba(247, 68, 78, 0.25);
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

    .info-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-top: 30px;
    }

    .info-box h6 {
        color: #f7444e;
        margin-bottom: 15px;
    }

    .info-box ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .info-box li {
        margin-bottom: 8px;
        color: #666;
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin: 20px 0;
    }

    .back-to-home {
        color: #f7444e;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
    }

    .back-to-home:hover {
        text-decoration: underline;
        color: #d43c45;
    }

    .track-container {
        background-color: #d1c9c9;
        padding: 60px 0;
        width: 96%;
        border-radius: 10px;
        margin: 30px auto 40px;
    }

    /* ========== CONTACT & INFO SECTIONS ========== */
    .contact_section,
    .info_section {
        width: 96%;
        border-radius: 10px;
        margin: 0 auto 40px;
    }

    .contact_section {
        background-color: #f8f9fa;
        padding: 60px 0;
    }

    .info_section {
        background-color: #2c2c2c;
        padding: 60px 0 20px;
    }

    /* ========== RESPONSIVE DESIGN ========== */
    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .carousel-item {
            height: 600px;
        }

        .img-box img {
            max-height: 500px;
            max-width: 600px;
        }
    }

    /* Medium devices (tablets, 768px to 991px) */
    @media (max-width: 991px) {
        .slider_section {
            padding: 0 35px;
        }

        .carousel-item {
            height: 500px;
        }

        .detail-box h1 {
            font-size: 36px;
            text-align: left;
            /* Don't center on tablet */
        }

        .detail-box p {
            font-size: 15px;
            text-align: left;
            /* Don't center on tablet */
            max-width: 100%;
        }

        .detail-box a {
            display: inline-block;
            width: auto;
            margin: 0;
        }

        .detail-box {
            padding: 30px 15px;
            text-align: left;
            /* Don't center on tablet */
        }

        .img-box {
            padding: 15px;
        }

        .img-box img {
            max-height: 350px;
            max-width: 100%;
        }

        .contact_section,
        .info_section {
            padding: 40px 0 !important;
        }

        .track-card {
            padding: 30px;
        }
    }

    /* Small devices (landscape phones, 576px to 767px) */
    @media (max-width: 767px) {
        .slider_section {
            padding: 0 24px;
        }

        .carousel-item {
            height: auto;
            min-height: 600px;
        }

        .row {
            flex-direction: column;
        }

        .col-md-7,
        .col-md-5 {
            width: 100%;
            max-width: 100%;
        }

        .detail-box {
            order: 2;
            padding: 20px 10px;
            text-align: center;
            /* Center on mobile */
        }

        .img-box {
            order: 1;
            padding: 30px 20px;
            height: 300px;
        }

        .img-box img {
            max-height: 250px;
            width: 100%;
            max-width: 500px;
        }

        .detail-box h1 {
            font-size: 28px;
            margin-top: 10px;
            text-align: center;
        }

        .detail-box p {
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        .detail-box a {
            padding: 10px 25px;
            font-size: 14px;
            margin: 0 auto;
            display: block;
            width: fit-content;
        }

        .contact_section,
        .info_section {
            padding: 30px 0 !important;
        }

        .track-container {
            width: 95%;
            padding: 40px 0;
            margin: 20px auto 30px;
        }

        .track-card {
            padding: 20px;
            margin: 30px auto;
        }

        .track-icon {
            font-size: 3rem;
        }
    }

    /* Extra small devices (portrait phones, less than 576px) */
    @media (max-width: 576px) {
        .slider_section {
            padding: 0 25px;
        }

        .carousel-item {
            min-height: 550px;
        }

        .detail-box h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .detail-box p {
            font-size: 13px;
            line-height: 1.5;
        }

        .detail-box a {
            padding: 8px 20px;
            font-size: 13px;
        }

        .img-box {
            height: 250px;
            padding: 20px 15px;
        }

        .img-box img {
            max-height: 200px;
            max-width: 400px;
        }

        .track-card {
            padding: 15px;
        }
    }

    /* Very small devices (less than 400px) */
    @media (max-width: 400px) {
        .carousel-item {
            min-height: 500px;
        }

        .detail-box h1 {
            font-size: 22px;
        }

        .img-box {
            height: 200px;
        }

        .img-box img {
            max-height: 180px;
            max-width: 350px;
        }
    }

    /* Footer section */
    .footer_section {
        border-top: 1px solid #444;
        padding: 20px 0;
        margin-top: 40px;
    }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section -->
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
                            <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
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
                                        <a href="{{ route('contact') }}">
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

    <!-- Track Order Section -->
    <!-- Track Order Section -->
    <section class="track-container">
        <div class="container">
            <div class="track-card">
                <!-- Header -->
                <div class="text-center mb-4">
                    <i class="fas fa-search-location track-icon"></i>
                    <h2 class="mb-3">Track Your Order</h2>
                    <p class="text-muted">Enter your order number and email to view order details</p>
                </div>

                <!-- Error Messages -->
                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <!-- Track Order Form -->
                <form action="{{ route('guest.track.order.post') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="order_number" class="form-label fw-bold">Order Number *</label>
                        <input type="text" class="form-control form-control-lg" id="order_number" name="order_number"
                            value="{{ old('order_number') }}" placeholder="e.g., ORD-ABC123-20231215" required>
                        @error('order_number')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email Address *</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                            value="{{ old('email') }}" placeholder="your.email@example.com" required>
                        @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i> Track Order
                        </button>
                    </div>
                </form>


                <!-- Help Information -->
                <div class="info-box">
                    <h6><i class="fas fa-info-circle me-2"></i> How to find your order number?</h6>
                    <ul>
                        <li>Check your email for order confirmation</li>
                        <li>Look for an email from {{ config('app.name') }}</li>
                        <li>Order number format: ORD-XXXXXX-YYYYMMDD</li>
                        <li>Contact support if you can't find it</li>
                    </ul>
                </div>

                <!-- Navigation -->
                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="back-to-home">
                        <i class="fas fa-arrow-left me-2"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>



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
                <ul class="mb-0">
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
                <p style="color: #aaa; margin: 0;">
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/" style="color: #f7444e; text-decoration: none;">Web Tech Knowledge</a>
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

    // Auto-focus on first input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('order_number').focus();
    });

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