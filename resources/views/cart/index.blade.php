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

    <!-- Bootstrap 4 CDN (Navbar এর জন্য) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
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

    /* Cart Page Styles */
    .cart-container {
        max-width: 1200px;
        margin: 40px auto;
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
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
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
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('cart.index') }}">Cart Details</a>
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
                            <span class="cart-count">0</span>
                        </a>
                        <form class="form-inline">
                            <button class="btn nav_search-btn" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Cart Container -->
        <div class="cart-container">
            <div class="cart-header">
                <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
                <p>Review your items and proceed to checkout</p>
            </div>

            @if($cartItems->isEmpty())
            <!-- Empty Cart -->
            <div class="cart-card empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="continue-btn">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
            @else
            @php
            // Calculate totals from controller
            $subtotal = 0;
            $itemCount = 0;
            foreach($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
            $itemCount += $item->quantity;
            }
            $shipping = 0;
            $tax = $subtotal * 0.10; // 10% tax
            $total = $subtotal + $shipping + $tax;
            @endphp

            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="cart-card">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items-body">
                                @foreach($cartItems as $item)
                                @php
                                $itemTotal = $item->price * $item->quantity;
                                @endphp
                                <tr class="cart-item" id="cart-item-{{ $item->id }}">
                                    <td data-label="Product">
                                        <div class="product-info">
                                            @php
                                            $imagePath = $item->product->product_image ?? 'images/default-product.jpg';
                                            $imageExists = file_exists(public_path($imagePath));
                                            @endphp
                                            <img src="{{ $imageExists ? asset($imagePath) : asset('images/default-product.jpg') }}"
                                                alt="{{ $item->product_title }}" class="product-image">
                                            <div class="product-details">
                                                <h4>{{ $item->product_title }}</h4>
                                                @if($item->product)
                                                <p>SKU: {{ $item->product->product_sku ?? 'N/A' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Price" class="price">${{ number_format($item->price, 2) }}</td>
                                    <td data-label="Quantity">
                                        <div class="quantity-control">
                                            <button class="quantity-btn decrease-btn"
                                                data-id="{{ $item->id }}">-</button>
                                            <input type="number" class="quantity-input" value="{{ $item->quantity }}"
                                                min="1" data-id="{{ $item->id }}" id="quantity-{{ $item->id }}">
                                            <button class="quantity-btn increase-btn"
                                                data-id="{{ $item->id }}">+</button>
                                        </div>
                                    </td>
                                    <td data-label="Total" class="price item-total" id="total-{{ $item->id }}">
                                        ${{ number_format($itemTotal, 2) }}
                                    </td>
                                    <td data-label="Action">
                                        <button class="remove-btn" data-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="continue-btn">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4">
                    <div class="cart-card cart-summary">
                        <h4 class="mb-4">Order Summary</h4>

                        <div class="summary-row">
                            <span>Items</span>
                            <span class="summary-value" id="item-count">{{ $itemCount }} items</span>
                        </div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="summary-value" id="subtotal">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping</span>
                            <span class="summary-value" id="shipping">${{ number_format($shipping, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span class="summary-value" id="tax">${{ number_format($tax, 2) }}</span>
                        </div>

                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="summary-value" id="cart-total">${{ number_format($total, 2) }}</span>
                        </div>

                        <button class="checkout-btn" id="checkout-btn">
                            <i class="fas fa-lock"></i> Proceed to Checkout
                        </button>

                        <p class="text-center mt-3 text-muted small">
                            <i class="fas fa-lock"></i> Secure checkout
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

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
                    <p style="color: #aaa; margin: 0;">
                        &copy; <span id="displayYear"></span> All Rights Reserved By
                        <a href="https://html.design/" style="color: #f7444e; text-decoration: none;">Web Tech
                            Knowledge</a>
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

    <!-- Cart JavaScript -->
    <script>
    $(document).ready(function() {
        // Initialize CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Function to update cart count in navbar
        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}',
                type: 'GET',
                success: function(data) {
                    $('.cart-count').text(data.count || 0);
                }
            });
        }

        // Function to recalculate totals from UI
        function recalculateTotals() {
            let subtotal = 0;
            let itemCount = 0;

            // Calculate subtotal and item count from all items
            $('.item-total').each(function() {
                const totalText = $(this).text().replace('$', '').replace(',', '');
                subtotal += parseFloat(totalText);
            });

            // Calculate item quantities
            $('.quantity-input').each(function() {
                itemCount += parseInt($(this).val()) || 0;
            });

            // Get shipping (you can make this dynamic)
            const shipping = 0;

            // Calculate tax (10% for example)
            const tax = subtotal * 0.10;
            const total = subtotal + shipping + tax;

            // Update display
            $('#subtotal').text('$' + subtotal.toFixed(2));
            $('#shipping').text('$' + shipping.toFixed(2));
            $('#tax').text('$' + tax.toFixed(2));
            $('#cart-total').text('$' + total.toFixed(2));
            $('#item-count').text(itemCount + ' items');
        }

        // Function to update quantity via AJAX
        function updateQuantity(itemId, quantity) {
            const $input = $('#quantity-' + itemId);
            const originalValue = $input.val();

            // Show loading
            $input.prop('disabled', true);

            $.ajax({
                url: '/cart/update/' + itemId,
                type: 'PUT',
                data: {
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update item total
                        $('#total-' + itemId).text('$' + response.new_total);

                        // Recalculate and update all totals
                        recalculateTotals();

                        // Update cart count in navbar
                        updateCartCount();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false,
                            position: 'top-end',
                            toast: true
                        });
                    } else {
                        Swal.fire('Error', 'Failed to update quantity', 'error');
                        $input.val(originalValue);
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Failed to update quantity. Please try again.', 'error');
                    $input.val(originalValue);
                },
                complete: function() {
                    $input.prop('disabled', false);
                }
            });
        }

        // Function to remove item from cart
        function removeItem(itemId) {
            $.ajax({
                url: '/cart/remove/' + itemId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        // Remove item row with animation
                        $('#cart-item-' + itemId).fadeOut(300, function() {
                            $(this).remove();

                            // Recalculate totals
                            recalculateTotals();

                            // Update cart count
                            updateCartCount();

                            // Check if cart is empty
                            if ($('#cart-items-body tr').length === 0) {
                                location.reload(); // Reload to show empty cart message
                            }
                        });

                        Swal.fire('Removed!', 'Item has been removed from cart.', 'success');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to remove item', 'error');
                }
            });
        }

        // Initial cart count load
        updateCartCount();

        // Increase quantity
        $(document).on('click', '.increase-btn', function() {
            const itemId = $(this).data('id');
            const $input = $('#quantity-' + itemId);
            let quantity = parseInt($input.val()) || 1;
            $input.val(quantity + 1);
            updateQuantity(itemId, quantity + 1);
        });

        // Decrease quantity
        $(document).on('click', '.decrease-btn', function() {
            const itemId = $(this).data('id');
            const $input = $('#quantity-' + itemId);
            let quantity = parseInt($input.val()) || 1;

            if (quantity > 1) {
                $input.val(quantity - 1);
                updateQuantity(itemId, quantity - 1);
            }
        });

        // Direct quantity input change
        $(document).on('change', '.quantity-input', function() {
            const itemId = $(this).data('id');
            let quantity = parseInt($(this).val()) || 1;

            if (quantity < 1) quantity = 1;
            $(this).val(quantity);
            updateQuantity(itemId, quantity);
        });

        // Remove item from cart
        $(document).on('click', '.remove-btn', function() {
            const itemId = $(this).data('id');

            Swal.fire({
                title: 'Remove Item',
                text: 'Are you sure you want to remove this item from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    removeItem(itemId);
                }
            });
        });

        // Checkout button
        $('#checkout-btn').click(function() {
            @if(Auth::check())
            Swal.fire({
                title: 'Proceed to Checkout?',
                text: 'You will be redirected to the checkout page.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2f3ad1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, checkout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to checkout page
                    window.location.href = '/checkout';
                }
            });
            @else
            Swal.fire({
                title: 'Login Required',
                text: 'Please login or register to proceed with checkout.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#2f3ad1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Login',
                cancelButtonText: 'Continue as Guest'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("login") }}';
                }
            });
            @endif
        });

        // Auto-update cart count every 30 seconds
        setInterval(updateCartCount, 30000);
    });
    </script>
</body>

</html>