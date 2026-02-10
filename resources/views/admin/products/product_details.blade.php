<!DOCTYPE html>
<html lang="en">

<head>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />

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

    /* Product Detail Styles */
    .product-detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .back-btn {
        margin-bottom: 30px;
    }

    .back-btn a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s;
    }

    .back-btn a:hover {
        color: #2f3ad1;
    }

    .product-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        padding: 30px;
    }

    .product-image-container {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #f9f9f9;
        padding: 20px;
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s;
    }

    .product-image:hover {
        transform: scale(1.03);
    }

    .product-info {
        padding-left: 40px;
    }

    .product-title {
        font-size: 32px;
        font-weight: 700;
        color: #222;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .product-price-section {
        margin-bottom: 25px;
    }

    .product-price {
        font-size: 36px;
        font-weight: 700;
        color: #2f3ad1;
        display: inline-block;
        margin-right: 15px;
    }

    .product-old-price {
        font-size: 22px;
        color: #999;
        text-decoration: line-through;
        display: inline-block;
    }

    .product-discount {
        background: #2f3ad1;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        margin-left: 10px;
    }

    .product-meta {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .meta-item:last-child {
        margin-bottom: 0;
    }

    .meta-icon {
        width: 35px;
        height: 35px;
        background: #2f3ad1;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 14px;
    }

    .meta-text {
        font-size: 15px;
    }

    .meta-text strong {
        color: #333;
        margin-right: 5px;
    }

    .meta-text span {
        color: #666;
    }

    .description-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #2f3ad1;
        display: inline-block;
    }

    .product-description {
        color: #555;
        line-height: 1.8;
        font-size: 15px;
    }

    .add-to-cart-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        margin-top: 30px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .quantity-label {
        font-weight: 600;
        color: #333;
        font-size: 16px;
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
    }

    .quantity-btn {
        width: 45px;
        height: 45px;
        background: #fff;
        border: 2px solid #ddd;
        font-size: 20px;
        color: #333;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-btn:hover {
        background: #2f3ad1;
        color: white;
        border-color: #2f3ad1;
    }

    .quantity-btn:first-child {
        border-radius: 8px 0 0 8px;
    }

    .quantity-btn:last-child {
        border-radius: 0 8px 8px 0;
    }

    .quantity-input {
        width: 70px;
        height: 45px;
        text-align: center;
        border: 2px solid #ddd;
        border-left: none;
        border-right: none;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, #2f3ad1, #4a5de0);
        color: white;
        border: none;
        padding: 16px 40px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        box-shadow: 0 5px 15px rgba(255, 51, 104, 0.3);
    }

    .btn-add-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 51, 104, 0.4);
    }

    .btn-add-cart:active {
        transform: translateY(-1px);
    }

    .btn-add-cart:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .share-section {
        margin-top: 30px;
        text-align: center;
    }

    .share-title {
        font-size: 16px;
        color: #666;
        margin-bottom: 15px;
    }

    .share-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .share-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s;
    }

    .share-btn:hover {
        transform: translateY(-3px);
        color: white;
    }

    .share-btn.facebook:hover {
        background: #3b5998;
    }

    .share-btn.twitter:hover {
        background: #1da1f2;
    }

    .share-btn.pinterest:hover {
        background: #bd081c;
    }

    .share-btn.whatsapp:hover {
        background: #25d366;
    }

    @media (max-width: 991px) {
        .product-info {
            padding-left: 0;
            margin-top: 30px;
        }

        .product-image-container {
            height: 350px;
        }

        .product-title {
            font-size: 26px;
        }

        .product-price {
            font-size: 30px;
        }
    }

    @media (max-width: 576px) {
        .product-detail-container {
            margin: 20px auto;
        }

        .product-card {
            padding: 20px;
        }

        .product-image-container {
            height: 280px;
            padding: 15px;
        }

        .product-title {
            font-size: 22px;
        }

        .product-price {
            font-size: 26px;
        }

        .quantity-control {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .btn-add-cart {
            padding: 14px 20px;
            font-size: 16px;
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

    /* Spinner animation */
    .spinner {
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
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section -->
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
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                        </li>
                        <li class="nav-item">
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
                            <span>Dashboard</span>
                        </a>
                        @else
                        <a href="{{ route('login') }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Register</span>
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
                                            <a href="{{ route('contact') }}" class="btn btn-primary">
                                                Contact Us
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="img-box">
                                            <img style="width:600px;border-radius: 10px;"
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

        <!-- Product Detail Section -->
        <div class="product-detail-container">
            <!-- Back Button -->
            <div class="back-btn">
                <a href="{{ url('/') }}">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>

            <div class="product-card">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-lg-6">
                        <div class="product-image-container">
                            @php
                            $imageExists = $product->product_image && file_exists(public_path($product->product_image));
                            @endphp
                            <img src="{{ $imageExists ? asset($product->product_image) : asset('images/default-product.jpg') }}"
                                class="product-image" alt="{{ $product->product_title }}">
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            <!-- Product Title -->
                            <h1 class="product-title">{{ $product->product_title }}</h1>

                            <!-- Product Price -->
                            <div class="product-price-section">
                                <span class="product-price">${{ number_format($product->product_price, 2) }}</span>
                                @if($product->product_discount_price && $product->product_discount_price >
                                $product->product_price)
                                <span
                                    class="product-old-price">${{ number_format($product->product_discount_price, 2) }}</span>
                                <span class="product-discount">
                                    Save
                                    {{ number_format((($product->product_discount_price - $product->product_price) / $product->product_discount_price) * 100, 0) }}%
                                </span>
                                @endif
                            </div>

                            <!-- Product Meta Information -->
                            <div class="product-meta">
                                @if($product->product_category)
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="meta-text">
                                        <strong>Category:</strong>
                                        <span>{{ $product->product_category }}</span>
                                    </div>
                                </div>
                                @endif

                                @if($product->product_brand)
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <i class="fas fa-copyright"></i>
                                    </div>
                                    <div class="meta-text">
                                        <strong>Brand:</strong>
                                        <span>{{ $product->product_brand }}</span>
                                    </div>
                                </div>
                                @endif

                                @if($product->product_sku)
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <i class="fas fa-barcode"></i>
                                    </div>
                                    <div class="meta-text">
                                        <strong>SKU:</strong>
                                        <span>{{ $product->product_sku }}</span>
                                    </div>
                                </div>
                                @endif

                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="meta-text">
                                        <strong>Availability:</strong>
                                        <span class="text-success">In Stock</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Description -->
                            @if($product->product_description)
                            <div class="description-section">
                                <h3 class="section-title">Product Description</h3>
                                <div class="product-description">
                                    {{ $product->product_description }}
                                </div>
                            </div>
                            @endif

                            <!-- Add to Cart Section -->
                            <div class="add-to-cart-section">
                                <div class="quantity-control">
                                    <div class="quantity-label">Quantity:</div>
                                    <div class="quantity-wrapper">
                                        <button class="quantity-btn" id="decrease-qty">-</button>
                                        <input type="number" class="quantity-input" id="quantity" value="1" min="1">
                                        <button class="quantity-btn" id="increase-qty">+</button>
                                    </div>
                                </div>

                                <button class="btn-add-cart" id="add-to-cart-btn" data-product-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span id="add-to-cart-text">Add to Cart</span>
                                </button>
                            </div>

                            <!-- Share Section -->
                            <div class="share-section">
                                <div class="share-title">Share this product:</div>
                                <div class="share-buttons">
                                    <a href="#" class="share-btn facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="share-btn twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="share-btn pinterest">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                    <a href="#" class="share-btn whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
    $(document).ready(function() {
        // CSRF token setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Quantity control
        const decreaseBtn = $('#decrease-qty');
        const increaseBtn = $('#increase-qty');
        const quantityInput = $('#quantity');
        const addToCartBtn = $('#add-to-cart-btn');
        const addToCartText = $('#add-to-cart-text');

        // Decrease quantity
        if (decreaseBtn.length) {
            decreaseBtn.on('click', function() {
                let currentValue = parseInt(quantityInput.val());
                if (currentValue > 1) {
                    quantityInput.val(currentValue - 1);
                }
            });
        }

        // Increase quantity
        if (increaseBtn.length) {
            increaseBtn.on('click', function() {
                let currentValue = parseInt(quantityInput.val());
                quantityInput.val(currentValue + 1);
            });
        }

        // Add to cart function
        if (addToCartBtn.length) {
            addToCartBtn.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = $(this).data('product-id');
                const quantity = parseInt(quantityInput.val()) || 1;

                // Disable button and show loading
                addToCartBtn.prop('disabled', true);
                const originalText = addToCartText.text();
                addToCartText.html('<i class="fas fa-spinner fa-spin"></i> Adding...');

                // Send AJAX request
                $.ajax({
                    url: '/cart/add/' + productId,
                    type: 'POST',
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            // Success message - FIXED POSITION
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end',
                                timerProgressBar: true,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                customClass: {
                                    container: 'swal-container-fixed'
                                }
                            });

                            // Update cart count in navbar
                            updateCartCount();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Something went wrong!',
                                position: 'top-end',
                                toast: true,
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add product to cart. Please try again.',
                            position: 'top-end',
                            toast: true,
                            timer: 3000
                        });
                    },
                    complete: function() {
                        // Re-enable button
                        addToCartBtn.prop('disabled', false);
                        addToCartText.text(originalText);
                    }
                });
            });
        }

        // Function to update cart count in navbar
        function updateCartCount() {
            $.ajax({
                url: '/cart/count',
                type: 'GET',
                success: function(data) {
                    $('.cart-count').text(data.count || 0);
                }
            });
        }

        // Initial cart count load
        updateCartCount();

        // Also update when page loads
        $(window).on('load', function() {
            updateCartCount();
        });
    });
    </script>

    <!-- SweetAlert Custom CSS for fixed positioning -->
    <style>
    .swal2-container.swal2-top-end {
        padding-top: 60px !important;
        /* Adjust based on your navbar height */
    }

    .swal2-popup.swal2-toast {
        margin-top: 60px !important;
        z-index: 99999 !important;
    }

    /* Ensure popup stays on top of navbar */
    .swal2-container {
        z-index: 99999 !important;
    }

    /* Optional: Add animation for better UX */
    .animate__animated {
        animation-duration: 0.5s;
    }

    .animate__fadeInDown {
        animation-name: fadeInDown;
    }

    .animate__fadeOutUp {
        animation-name: fadeOutUp;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -100%, 0);
        }

        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes fadeOutUp {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            transform: translate3d(0, -100%, 0);
        }
    }
    </style>
</body>

</html>