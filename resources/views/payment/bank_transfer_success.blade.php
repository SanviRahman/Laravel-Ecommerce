<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transfer Payment Successful</title>
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

    <title>Giftos - Payment Success</title>

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

    .bank-icon {
        font-size: 30px;
        color: #28a745;
        margin-right: 10px;
        vertical-align: middle;
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

    .bank-details-card {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 10px;
        padding: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <h1 class="text-center mb-3" style="color: #28a745;">Bank Transfer Submitted Successfully!</h1>
            <p class="text-center text-muted mb-4">
                Your bank transfer payment details have been submitted. Please keep your transaction ID for
                verification.
            </p>

            <!-- Bank Icon -->
            <div class="text-center mb-4">
                <i class="fas fa-university bank-icon"></i>
                <h4>{{ $bank_name }} Transfer</h4>
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
                            <h6><i class="fas fa-university"></i> Bank Name</h6>
                            <p class="mb-0 fw-bold">{{ $bank_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-credit-card"></i> Account Number</h6>
                            <p class="mb-0 fw-bold">{{ $account_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-receipt"></i> Transaction ID</h6>
                            <p class="mb-0 fw-bold">{{ $transaction_id }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card">
                            <h6><i class="fas fa-dollar-sign"></i> Total Amount</h6>
                            <p class="mb-0 fw-bold">${{ number_format($order->total, 2) }}</p>
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
                            <h6><i class="fas fa-envelope"></i> Customer Email</h6>
                            <p class="mb-0 fw-bold">{{ $order->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Details -->
            @if(isset($bank_details) && count($bank_details) > 0)
            <div class="bank-details-card mt-4">
                <h5><i class="fas fa-info-circle"></i> Company Bank Details</h5>
                <p class="text-muted mb-3">Please transfer the amount to the following account:</p>
                <table class="table table-bordered">
                    <tbody>
                        @foreach($bank_details as $key => $value)
                        <tr>
                            <th width="40%">{{ $key }}</th>
                            <td><strong>{{ $value }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Verification Note -->
            <div class="verification-note mt-4">
                <h5><i class="fas fa-info-circle"></i> Important Note</h5>
                <p class="mb-2">Your payment is currently <strong>pending verification</strong>.</p>
                <p class="mb-2">Please complete the bank transfer within <strong>24 hours</strong> using the above
                    company bank details.</p>
                <p class="mb-0">Our accounts team will verify your payment within <strong>1-2 business days</strong>.
                    You will receive a confirmation email once verified.</p>
            </div>

            <!-- Next Steps -->
            <div class="mt-4">
                <h5><i class="fas fa-forward"></i> What Happens Next?</h5>
                <div class="row text-center mt-3">
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-money-check-alt fa-2x text-primary mb-2"></i>
                            <h6>Bank Transfer</h6>
                            <p class="small text-muted">Complete your bank transfer</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-search fa-2x text-info mb-2"></i>
                            <h6>Verification</h6>
                            <p class="small text-muted">We verify bank transaction</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-box fa-2x text-warning mb-2"></i>
                            <h6>Processing</h6>
                            <p class="small text-muted">Order prepared for shipping</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-shipping-fast fa-2x text-success mb-2"></i>
                            <h6>Delivery</h6>
                            <p class="small text-muted">Items shipped to address</p>
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
                    Need help with bank transfer? Contact our accounts team:
                    <br>
                    <i class="fas fa-phone"></i> +880 1234 567891 (Accounts) |
                    <i class="fas fa-envelope"></i> accounts@giftos.com
                </p>
            </div>
        </div>
    </div>

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

    // Copy bank details
    function copyBankDetails() {
        let details = '';
        @if(isset($bank_details))
        @foreach($bank_details as $key => $value)
        details += "{{ $key }}: {{ $value }}\n";
        @endforeach
        @endif

        navigator.clipboard.writeText(details).then(function() {
            alert('Bank details copied to clipboard!');
        });
    }

    // Auto redirect after 30 seconds (optional)
    setTimeout(function() {
        // window.location.href = "{{ url('/') }}";
    }, 30000);
    </script>
</body>

</html>