<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Banking Payment Successful</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .success-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 40px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
    }

    .success-icon i {
        font-size: 50px;
        color: white;
    }

    .order-details {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-top: 30px;
    }

    .info-card {
        background: #e9ecef;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .payment-method-icon {
        font-size: 30px;
        margin-right: 10px;
        vertical-align: middle;
    }

    .bkash {
        color: #e2136e;
    }

    .rocket {
        color: #9c1d7a;
    }

    .nagad {
        color: #e6131d;
    }

    .btn-home {
        background: #007bff;
        color: white;
        padding: 12px 30px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: all 0.3s;
    }

    .btn-home:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .verification-note {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-top: 20px;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <!-- end hero area -->
    <div class="container">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <h1 class="text-center mb-3" style="color: #28a745;">Payment Submitted Successfully!</h1>
            <p class="text-center text-muted mb-4">
                Your mobile banking payment has been submitted successfully. Please keep your transaction ID for
                verification.
            </p>

            <!-- Payment Method Icon -->
            <div class="text-center mb-4">
                @if($payment_method == 'BKash')
                <i class="fas fa-mobile-alt payment-method-icon bkash"></i>
                <h4>BKash Payment</h4>
                @elseif($payment_method == 'Rocket')
                <i class="fas fa-rocket payment-method-icon rocket"></i>
                <h4>DBBL Rocket Payment</h4>
                @elseif($payment_method == 'Nagad')
                <i class="fas fa-wallet payment-method-icon nagad"></i>
                <h4>Nagad Payment</h4>
                @endif
            </div>

            <!-- Order Details -->
            <div class="order-details">
                <h4 class="mb-4"><i class="fas fa-receipt"></i> Order & Payment Details</h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-hashtag"></i> Order Number</h6>
                            <p class="mb-0 fw-bold">{{ $order->order_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-calendar"></i> Order Date</h6>
                            <p class="mb-0 fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-phone"></i> Mobile Number</h6>
                            <p class="mb-0 fw-bold">{{ $mobile_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-receipt"></i> Transaction ID</h6>
                            <p class="mb-0 fw-bold">{{ $transaction_id }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-user"></i> Customer Name</h6>
                            <p class="mb-0 fw-bold">{{ $order->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-dollar-sign"></i> Total Amount</h6>
                            <p class="mb-0 fw-bold">${{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Note -->
            <div class="verification-note">
                <h5><i class="fas fa-info-circle"></i> Important Note</h5>
                <p class="mb-2">Your payment is currently <strong>pending verification</strong>.</p>
                <p class="mb-0">Our team will verify your payment within <strong>2-3 hours</strong>. You will receive a
                    confirmation email once verified.</p>
            </div>

            <!-- Payment Instructions -->
            @if(isset($instructions) && count($instructions) > 0)
            <div class="mt-4">
                <h5><i class="fas fa-list-alt"></i> Payment Instructions</h5>
                <ul class="list-group">
                    @foreach($instructions as $instruction)
                    <li class="list-group-item d-flex">
                        <i class="fas fa-check text-success me-2 mt-1"></i>
                        <span>{{ $instruction }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="mt-4">
                <h5><i class="fas fa-forward"></i> What Happens Next?</h5>
                <div class="row text-center mt-3">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-search fa-2x text-primary mb-2"></i>
                            <h6>Payment Verification</h6>
                            <p class="small text-muted">We verify your transaction with bank records</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-box fa-2x text-warning mb-2"></i>
                            <h6>Order Processing</h6>
                            <p class="small text-muted">Your order is prepared for shipping</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-shipping-fast fa-2x text-success mb-2"></i>
                            <h6>Delivery</h6>
                            <p class="small text-muted">Items shipped to your address</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-home me-2"></i> Back to Home
                </a>
                <a href="{{ route('guest.track.order') }}" class="btn-home ms-3" style="background: #6c757d;">
                    <i class="fas fa-truck me-2"></i> Track Order
                </a>
                <!-- Invoice Download Button - NEW -->
                <a href="{{ route('invoice.download', $order->order_number) }}" class="btn-home ms-3"
                    style="background: #28a745;" target="_blank">
                    <i class="fas fa-download me-2"></i> Download Invoice
                </a>
                <a href="javascript:window.print()" class="btn-home ms-3" style="background: #17a2b8;">
                    <i class="fas fa-print me-2"></i> Print Receipt
                </a>
            </div>

            <!-- Contact Information -->
            <div class="text-center mt-4">
                <p class="text-muted small">
                    Need help? Contact our support team:
                    <br>
                    <i class="fas fa-phone"></i> +880 1234 567890 |
                    <i class="fas fa-envelope"></i> support@giftos.com
                </p>
            </div>
        </div>
    </div>


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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Print receipt function
    function printReceipt() {
        window.print();
    }

    // Copy transaction ID
    function copyTransactionId() {
        const text = "{{ $transaction_id }}";
        navigator.clipboard.writeText(text).then(function() {
            alert('Transaction ID copied to clipboard!');
        });
    }

    // Auto redirect after 30 seconds (optional)
    setTimeout(function() {
        // window.location.href = "{{ url('/') }}";
    }, 30000);
    </script>
</body>

</html>