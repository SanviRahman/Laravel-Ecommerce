<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap 4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />

    <title>Giftos</title>

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

    /* Button Styles */
    .btn-add-cart {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: linear-gradient(135deg, #2f3ad1, #4a5de0);
        color: white;
        border: none;
        padding: 16px 40px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        box-shadow: 0 5px 15px rgba(47, 58, 209, 0.3);
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        text-decoration: none;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #1a248c, #2f3ad1);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(47, 58, 209, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-add-cart:active {
        transform: translateY(-1px);
    }

    .btn-add-cart:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-buy-now {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border: none;
        padding: 16px 40px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        letter-spacing: 0.5px;
        text-decoration: none;
        border: none;
    }

    .btn-buy-now:hover {
        background: linear-gradient(135deg, #218838, #1ba87e);
        color: white;
        text-decoration: none;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-buy-now:active {
        transform: translateY(-1px);
    }

    .btn-buy-now:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-buy-now i,
    .btn-add-cart i {
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .btn-buy-now:hover i,
    .btn-add-cart:hover i {
        transform: scale(1.1);
    }

    /* Size Selection Styles */
    .size-selection-section {
        margin-bottom: 25px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .size-label {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .size-options {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .size-option {
        margin-right: 0;
    }

    .size-option .size-label-btn {
        background: white;
        border: 2px solid #dee2e6;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        color: #495057;
        transition: all 0.3s;
        min-width: 70px;
        text-align: center;
        cursor: pointer;
        display: inline-block;
        margin: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .size-option .size-label-btn:hover {
        border-color: #2f3ad1;
        background: #f0f2ff;
        color: #2f3ad1;
        transform: translateY(-2px);
    }

    .size-option input[type="radio"]:checked+.size-label-btn {
        background: #2f3ad1;
        color: white;
        border-color: #2f3ad1;
        box-shadow: 0 4px 10px rgba(47, 58, 209, 0.2);
    }

    .measurement-details {
        margin-top: 20px;
        padding: 15px;
        background-color: white;
        border-radius: 8px;
        border-left: 4px solid #2f3ad1;
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

    /* Alert Messages */
    .alert {
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-left: 4px solid;
    }

    .alert-success {
        background-color: #d4edda;
        border-left-color: #28a745;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-left-color: #dc3545;
        color: #721c24;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-left-color: #ffc107;
        color: #856404;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-left-color: #17a2b8;
        color: #0c5460;
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

        .btn-add-cart,
        .btn-buy-now {
            padding: 14px 20px;
            font-size: 16px;
        }

        .size-options {
            gap: 8px;
        }

        .size-option .size-label-btn {
            padding: 10px 18px !important;
            min-width: 50px;
            font-size: 14px;
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
                                Cart Details
                                @php
                                $cartCount = session('cart_count', 0);
                                @endphp
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('guest.track.order') }}" class="nav-link">
                                Track Order
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
                                    <div class="col-md-5">
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

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="container mt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        @if(session('warning'))
        <div class="container mt-4">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle"></i> {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="container mt-4">
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
        @endif

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
                            $imagePath = $product->product_image;
                            $imageExists = $imagePath && file_exists(public_path($imagePath));
                            @endphp
                            <img src="{{ $imageExists ? asset($imagePath) : asset('images/default-product.jpg') }}"
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
                                @if(!empty($product->product_discount_price) && $product->product_discount_price >
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
                                @if(!empty($product->product_category))
                                <div class="meta-item">
                                    <div class="meta-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="meta-text">
                                        <strong>Category:</strong>
                                        <span>
                                            @php
                                            // Try to get category name from relationship
                                            if ($product->category) {
                                            echo $product->category->name;
                                            } else {
                                            // Try to find category by ID
                                            $category = \App\Models\Category::find($product->product_category);
                                            echo $category ? $category->name : 'Uncategorized';
                                            }
                                            @endphp
                                        </span>
                                    </div>
                                </div>
                                @endif

                                @if(!empty($product->product_brand))
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

                                @if(!empty($product->product_sku))
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
                                        @if($product->product_quantity > 0)
                                        <span class="text-success">In Stock ({{ $product->product_quantity }}
                                            available)</span>
                                        @else
                                        <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Product Description -->
                            @if(!empty($product->product_description))
                            <div class="description-section">
                                <h3 class="section-title">Product Description</h3>
                                <div class="product-description">
                                    {{ $product->product_description }}
                                </div>
                            </div>
                            @endif

                            <!-- SIZE SELECTION - FIXED AND SIMPLIFIED -->
                            @php
                            // SIMPLIFIED CLOTHING CATEGORY DETECTION
                            $isClothingProduct = false;
                            $categoryName = '';

                            // Get category name
                            if ($product->category) {
                            $categoryName = $product->category->name;
                            } else {
                            $category = \App\Models\Category::find($product->product_category);
                            $categoryName = $category ? $category->name : '';
                            }

                            // Define clothing keywords
                            $clothingKeywords = ['cloth', 'clothing', 'fashion', 'men', 'women', 'kids', 'apparel',
                            't-shirt', 'shirt', 'pant', 'dress', 'jacket', 'hoodie', 'sweater'];

                            // Check if category name contains clothing keywords
                            foreach ($clothingKeywords as $keyword) {
                            if (stripos($categoryName, $keyword) !== false) {
                            $isClothingProduct = true;
                            break;
                            }
                            }

                            // Also check product_category field directly
                            if (!$isClothingProduct) {
                            $categoryValue = is_numeric($product->product_category) ? '' : $product->product_category;
                            foreach ($clothingKeywords as $keyword) {
                            if (stripos($categoryValue, $keyword) !== false) {
                            $isClothingProduct = true;
                            break;
                            }
                            }
                            }

                            // Get available sizes
                            $productSizes = [];
                            if ($isClothingProduct) {
                            if (!empty($product->available_sizes)) {
                            if (is_array($product->available_sizes)) {
                            $productSizes = $product->available_sizes;
                            } elseif (is_string($product->available_sizes)) {
                            $decoded = json_decode($product->available_sizes, true);
                            $productSizes = is_array($decoded) ? $decoded : ['S', 'M', 'L', 'XL', 'XXL'];
                            }
                            } else {
                            // Default sizes
                            $productSizes = ['S', 'M', 'L', 'XL', 'XXL'];
                            }
                            }
                            @endphp

                            <!-- ADD TO CART FORM - LARAVEL BASED (NO JAVASCRIPT) -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" id="form-quantity" value="1">

                                <!-- DISPLAY SIZE SECTION IF CLOTHING PRODUCT -->
                                @if($isClothingProduct && !empty($productSizes))
                                <div class="size-selection-section">
                                    <div class="size-label">
                                        <i class="fas fa-ruler-combined mr-2"></i> Select Size:
                                    </div>
                                    <div class="size-options">
                                        @foreach($productSizes as $index => $size)
                                        <div class="size-option">
                                            <input type="radio" class="size-radio d-none" name="size"
                                                id="size_{{ $size }}" value="{{ $size }}"
                                                {{ $index == 0 ? 'checked' : '' }} required>
                                            <label for="size_{{ $size }}" class="size-label-btn">
                                                {{ $size }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>

                                    @if(!empty($product->measurement_details))
                                    <div class="measurement-details">
                                        <div class="font-weight-bold mb-2">
                                            <i class="fas fa-tape mr-2"></i> Measurement Guide:
                                        </div>
                                        <div class="text-muted">{{ $product->measurement_details }}</div>
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Add to Cart Section -->
                                <div class="add-to-cart-section">
                                    <div class="quantity-control">
                                        <div class="quantity-label">Quantity:</div>
                                        <div class="quantity-wrapper">
                                            <button type="button" class="quantity-btn" id="decrease-qty">-</button>
                                            <input type="number" class="quantity-input" id="quantity" name="quantity"
                                                value="1" min="1" max="{{ $product->product_quantity }}">
                                            <button type="button" class="quantity-btn" id="increase-qty">+</button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-add-cart" id="add-to-cart-btn"
                                        {{ $product->product_quantity < 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </form>

                            <!-- Buy Now Form -->
                            <form action="{{ route('buy.now', $product->id) }}" method="POST" id="buy-now-form">
                                @csrf
                                <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
                                @if($isClothingProduct && !empty($productSizes))
                                <input type="hidden" name="size" id="buy-now-size"
                                    value="{{ $productSizes[0] ?? 'S' }}">
                                @endif
                                <button type="submit" style="padding: 20px 20px;" class="btn-buy-now"
                                    {{ $product->product_quantity < 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-bolt"></i>
                                    <span>Buy Now</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="contact_section" style="background-color: #f8f9fa; padding: 60px 0;">
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
    <section class="info_section layout_padding2-top"
        style="background-color: #2c2c2c; color: white; padding: 60px 0 20px; border-radius: 10px; margin: 0 2% 40px;">
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
                            consectetur adipiscing elit, sed doLorem ipsum dolor sit amet.
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
                            consectetur adipiscing elit, sed doLorem ipsum dolor sit amet.
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Simple JavaScript for Quantity Control Only (No AJAX) -->
    <script>
    $(document).ready(function() {
        // ============== QUANTITY CONTROL ONLY ==============
        const quantityInput = $('#quantity');
        const decreaseBtn = $('#decrease-qty');
        const increaseBtn = $('#increase-qty');
        const maxStock = {
            {
                $product - > product_quantity ?? 0
            }
        };

        // Decrease quantity
        decreaseBtn.on('click', function() {
            let currentValue = parseInt(quantityInput.val()) || 1;
            if (currentValue > 1) {
                quantityInput.val(currentValue - 1);
                // Update both form fields
                $('#form-quantity').val(currentValue - 1);
                $('#buy-now-quantity').val(currentValue - 1);
            }
        });

        // Increase quantity
        increaseBtn.on('click', function() {
            let currentValue = parseInt(quantityInput.val()) || 1;
            if (currentValue < maxStock) {
                quantityInput.val(currentValue + 1);
                // Update both form fields
                $('#form-quantity').val(currentValue + 1);
                $('#buy-now-quantity').val(currentValue + 1);
            } else {
                // Simple alert (no SweetAlert)
                alert('Only ' + maxStock + ' items available in stock.');
            }
        });

        // Validate manual quantity input
        quantityInput.on('change input', function() {
            let val = parseInt($(this).val()) || 1;
            if (val < 1) val = 1;
            if (val > maxStock) val = maxStock;
            $(this).val(val);
            $('#form-quantity').val(val);
            $('#buy-now-quantity').val(val);
        });

        // ============== SIZE SELECTION FOR BUY NOW ==============
        @if($isClothingProduct && !empty($productSizes))
        // Update buy now size when size changes
        $('input[name="size"]').on('change', function() {
            const selectedSize = $(this).val();
            $('#buy-now-size').val(selectedSize);
        });
        @endif
    });
    </script>
</body>

</html>