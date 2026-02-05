<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-search"></i> Track Your Order</h3>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('order.track.post') }}">
                            @csrf
                            <div class="form-group">
                                <label for="order_number">Order Number</label>
                                <input type="text" class="form-control" id="order_number" name="order_number" 
                                       placeholder="e.g., ORD-20231215-0001">
                                <small class="form-text text-muted">
                                    Enter the order number you received after placing order.
                                </small>
                            </div>
                            <div class="text-center mb-3">
                                <strong>OR</strong>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="email@example.com">
                                <small class="form-text text-muted">
                                    Enter the email address used for the order.
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> Track Order
                            </button>
                        </form>
                        
                        @if(isset($order))
                            <hr>
                            <h4>Order Details</h4>
                            <div class="alert alert-success">
                                <strong>Order Found!</strong>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Order Number:</th>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge badge-info">Processing</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge badge-primary">Shipped</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge badge-success">Delivered</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order Date:</th>
                                    <td>{{ $order->created_at->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Name:</th>
                                    <td>{{ $order->name }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </table>
                            <a href="{{ route('order.success', ['id' => $order->id]) }}" class="btn btn-success">
                                View Full Order Details
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-body">
                        <h5><i class="fas fa-question-circle"></i> Need Help?</h5>
                        <p class="mb-1">If you can't find your order or need assistance:</p>
                        <ul>
                            <li>Check your email for order confirmation</li>
                            <li>Make sure you entered the correct order number</li>
                            <li>Contact customer support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>