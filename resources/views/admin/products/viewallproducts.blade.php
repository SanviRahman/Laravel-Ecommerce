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
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
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
                            <a class="nav-link" href="#">
                                Shop
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Why Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Testimonial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">Cart Details</a>
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
                            <span class="cart-count">0</span>
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
    </div>
    <!-- end hero area -->

    <!-- shop section -->
    <br><br><br>
    <section class="shop_section layout_padding"
        style="background-color: #d1c9c9;padding: 60px 0;width: 96%;border-radius: 10px;margin: 0 auto 40px;">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    ALL PRODUCTS
                </h2>
            </div>

            @if(isset($products) && count($products) > 0)
            <style>
            .product-grid {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .product-card-wrapper {
                padding: 10px;
                flex: 0 0 25%;
                max-width: 25%;
            }

            .product-card {
                background: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                border: 1px solid #f0f0f0;
                height: 100%;
                display: flex;
                flex-direction: column;
                position: relative;
            }

            .product-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
            }

            .product-image-container {
                height: 240px;
                overflow: hidden;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                position: relative;
            }

            .product-image {
                width: 100%;
                height: 100%;
                object-fit: contain;
                transition: transform 0.5s ease;
                max-height: 200px;
            }

            .product-card:hover .product-image {
                transform: scale(1.08);
            }

            .product-badge {
                position: absolute;
                top: 15px;
                right: 15px;
                background: #ff3368;
                color: white;
                padding: 5px 10px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: 600;
                z-index: 1;
            }

            .product-content {
                padding: 20px;
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .product-title {
                font-size: 15px;
                font-weight: 600;
                color: #333;
                margin-bottom: 12px;
                line-height: 1.4;
                min-height: 42px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .product-price {
                color: #ff3368;
                font-size: 18px;
                font-weight: 700;
                margin-top: auto;
            }

            .product-old-price {
                color: #999;
                text-decoration: line-through;
                font-size: 14px;
                margin-left: 8px;
            }

            .product-link {
                text-decoration: none;
                color: inherit;
                display: block;
                height: 100%;
            }

            /* Responsive Grid */
            @media (max-width: 1200px) {
                .product-card-wrapper {
                    flex: 0 0 33.333%;
                    max-width: 33.333%;
                }
            }

            @media (max-width: 992px) {
                .product-card-wrapper {
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .product-image-container {
                    height: 220px;
                    padding: 15px;
                }
            }

            @media (max-width: 768px) {
                .product-card-wrapper {
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .product-image-container {
                    height: 200px;
                }

                .product-content {
                    padding: 15px;
                }

                .product-title {
                    font-size: 14px;
                    min-height: 40px;
                }
            }

            @media (max-width: 576px) {
                .product-grid {
                    margin: 0 -5px;
                }

                .product-card-wrapper {
                    padding: 5px;
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .product-image-container {
                    height: 180px;
                    padding: 12px;
                }

                .product-content {
                    padding: 12px;
                }

                .product-title {
                    font-size: 13px;
                    min-height: 38px;
                }

                .product-price {
                    font-size: 16px;
                }
            }

            @media (max-width: 400px) {
                .product-card-wrapper {
                    flex: 0 0 100%;
                    max-width: 100%;
                }

                .product-image-container {
                    height: 220px;
                }
            }

            /* Add to Cart Button Styling */
            .add-to-cart-btn {
                border: none;
                background: linear-gradient(135deg, #2d43be 0%, #1a2a8f 100%);
                color: white;
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                width: 100%;
                margin-top: 10px;
                height: 42px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 10px rgba(45, 67, 190, 0.2);
            }

            .add-to-cart-btn:hover {
                background: linear-gradient(135deg, #1a2a8f 0%, #0f1a66 100%);
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(45, 67, 190, 0.3);
            }

            /* Ensure all buttons have same height */
            .product-card-wrapper {
                padding: 10px;
                flex: 0 0 25%;
                max-width: 25%;
                display: flex;
                flex-direction: column;
            }

            /* Responsive adjustments for button */
            @media (max-width: 1200px) {
                .product-card-wrapper {
                    flex: 0 0 33.333%;
                    max-width: 33.333%;
                }
            }

            @media (max-width: 992px) {
                .product-card-wrapper {
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .add-to-cart-btn {
                    height: 40px;
                    padding: 9px 12px;
                    font-size: 13px;
                }
            }

            @media (max-width: 576px) {
                .product-card-wrapper {
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .add-to-cart-btn {
                    height: 38px;
                    padding: 8px 10px;
                    font-size: 12px;
                    margin-top: 8px;
                }
            }

            @media (max-width: 400px) {
                .product-card-wrapper {
                    flex: 0 0 100%;
                    max-width: 100%;
                }

                .add-to-cart-btn {
                    height: 40px;
                    font-size: 13px;
                }
            }
            </style>

            <div class="product-grid">
                @foreach($products as $product)
                <div class="product-card-wrapper">
                    <div class="product-card">
                        <a href="{{ route('product.details', $product->id) }}" class="product-link">
                            <div class="product-image-container">
                                @php
                                $imageExists = $product->product_image &&
                                file_exists(public_path($product->product_image));
                                $hasDiscount = $product->product_discount_price && $product->product_discount_price >
                                $product->product_price;
                                @endphp

                                @if($imageExists)
                                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_title }}"
                                    class="product-image" loading="lazy">
                                @else
                                <img src="{{ asset('images/default-product.jpg') }}" alt="No Image Available"
                                    class="product-image" loading="lazy">
                                @endif

                                @if($hasDiscount)
                                <span class="product-badge">
                                    Save
                                    {{ number_format((($product->product_discount_price - $product->product_price) / $product->product_discount_price) * 100, 0) }}%
                                </span>
                                @endif
                            </div>

                            <div class="product-content">
                                <h6 class="product-title">
                                    {{ $product->product_title }}
                                </h6>
                                <div class="product-price">
                                    ${{ number_format($product->product_price, 2) }}
                                    @if($hasDiscount)
                                    <span class="product-old-price">
                                        ${{ number_format($product->product_discount_price, 2) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Add to Cart Button - Now properly sized and consistent -->
                    <button class="add-to-cart-btn" data-product-id="{{ $product->id }}"
                        data-product-title="{{ $product->product_title }}"
                        data-product-price="{{ $product->product_price }}">
                        <a href="{{ route('product.details', $product->id) }}"
                            style="color: white; text-decoration: none;">View Details</a>
                    </button>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <h4 class="text-muted">No products found</h4>
            </div>
            @endif

            <div class="btn-box">
                <a href="{{ route('index') }}">
                    View Latest Products
                </a>
            </div>


        </div>
    </section>

    <!-- end shop section -->

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
</body>

</html>