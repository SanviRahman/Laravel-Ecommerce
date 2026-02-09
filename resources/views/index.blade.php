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

    <title>
        E-Commerce
    </title>

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
    .product-box {
        transition: transform 0.3s ease;
    }

    .product-box:hover {
        transform: translateY(-5px);
    }

    .img-box img {
        width: 60%;
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
    }

    .box {
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .box:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .detail-box {
        padding: 15px;
    }

    .detail-box h6 {
        color: #333;
        font-weight: 600;
    }

    .detail-box span {
        color: #f7444e;
        font-weight: bold;
        font-size: 18px;
    }

    .btn-box a {
        background: #f7444e;
        color: white;
        padding: 10px 30px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: background 0.3s;
    }

    .btn-box a:hover {
        background: #d43c45;
    }

    .alert {
        margin: 20px 0;
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('payment.options') }}">
                                <i class="fas fa-credit-card mr-1"></i>
                                <span>Payment</span>
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
    </div>
    <!-- end hero area -->

    <!-- shop section -->
    <br><br><br>
    <section class="shop_section layout_padding"
        style="background-color: #d1c9c9;padding: 60px 0;width: 96%;border-radius: 10px;margin: 0 auto 40px;">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Latest Products
                </h2>
            </div>

            @if(isset($products) && count($products) > 0)
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="box product-box h-100 d-flex flex-column">
                        <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                            <!-- Image Container with fixed height -->
                            <div class="img-box" style="height: 250px; overflow: hidden; position: relative;">
                                @php
                                // Check if image exists
                                $imageExists = $product->product_image &&
                                file_exists(public_path($product->product_image));
                                @endphp

                                @if($imageExists)
                                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_title }}"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                @else
                                <img src="{{ asset('images/default-product.jpg') }}" alt="No Image Available"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                @endif

                                <!-- Discount badge (if any) -->
                                @if($product->product_discount_price && $product->product_discount_price >
                                $product->product_price)
                                <span
                                    style="position: absolute; top: 10px; right: 10px; background: #ff3368; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                                    Save
                                    {{ number_format((($product->product_discount_price - $product->product_price) / $product->product_discount_price) * 100, 0) }}%
                                </span>
                                @endif
                            </div>

                            <!-- Content with flex-grow to take remaining space -->
                            <div class="detail-box p-3 flex-grow-1 d-flex flex-column">
                                <h6 class="mb-2"
                                    style="font-weight: 600; font-size: 16px; line-height: 1.4; min-height: 45px;">
                                    {{ \Illuminate\Support\Str::limit($product->product_title, 25) }}
                                </h6>

                                <div class="mt-auto">
                                    <h6 class="mb-0" style="color: #ff3368; font-size: 18px; font-weight: 700;">
                                        ${{ number_format($product->product_price, 2) }}
                                        @if($product->product_discount_price && $product->product_discount_price >
                                        $product->product_price)
                                        <span class="text-muted"
                                            style="font-size: 14px; text-decoration: line-through; margin-left: 5px;">
                                            ${{ number_format($product->product_discount_price, 2) }}
                                        </span>
                                        @endif
                                    </h6>

                                    <!-- Add to Cart Button -->
                                    <button class="btn btn-sm btn-outline-primary mt-2 w-100 add-to-cart-btn"
                                        data-product-id="{{ $product->id }}"
                                        data-product-title="{{ $product->product_title }}"
                                        data-product-price="{{ $product->product_price }}"
                                        style="border-color: #2d43be; color: #2d43be; background-color: #2d43be; color: white; border-radius: 5px; padding: 8px 12px; font-size: 14px;">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <h4 class="text-muted">No products found</h4>
            </div>
            @endif

            <div class="btn-box">
                <a href="{{ route('viewallproducts') }}">
                    View All Products
                </a>
            </div>


        </div>
    </section>

    <!-- end shop section -->


    <br><br>
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

    <script>
    // Set current year in footer
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('displayYear').textContent = new Date().getFullYear();

        // Add Font Awesome if not loaded
        if (!document.querySelector('link[href*="fontawesome"]')) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
            document.head.appendChild(link);
        }
    });
    </script>


    <!-- end contact section -->
    <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('front_end/js/custom.js') }}"></script>

    <script>
    // Display current year in footer
    document.getElementById('displayYear').textContent = new Date().getFullYear();

    // Image error handler
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.img-box img');
        images.forEach(img => {
            img.onerror = function() {
                this.src = "{{ asset('images/default-product.jpg') }}";
                this.alt = "Image not found";
            };
        });
    });
    </script>
    <!-- Add this script at the bottom of your index.blade.php -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update cart count in navbar
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

        // Update cart count every 30 seconds
        setInterval(updateCartCount, 30000);
    });
    </script>
</body>

</html>