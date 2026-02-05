@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Edit Order #{{ $order->order_number }}</h2>
    </div>
</div>
@endsection

@section('content')
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="title">
                        <strong>Edit Order Details</strong>
                        <a href="{{ route('orders.view') }}" class="btn btn-sm btn-secondary float-right">
                            <i class="fa fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                    <div class="block-body">
                        <form action="{{ route('orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_number">Order Number</label>
                                        <input type="text" class="form-control" value="{{ $order->order_number }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="created_at">Order Date</label>
                                        <input type="text" class="form-control" value="{{ $order->created_at->format('d M, Y h:i A') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            <h5>Customer Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Customer Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name', $order->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ old('email', $order->email) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="text" class="form-control" id="phone" name="phone" 
                                               value="{{ old('phone', $order->phone) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Type</label>
                                        <input type="text" class="form-control" 
                                               value="{{ ucfirst($order->customer_type) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Shipping Address *</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $order->address) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="notes">Order Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $order->notes) }}</textarea>
                            </div>
                            
                            <hr>
                            <h5>Order Status</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Order Status *</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_status">Payment Status *</label>
                                        <select class="form-control" id="payment_status" name="payment_status" required>
                                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            <h5>Order Items</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                @if($item->product && $item->product->product_image)
                                                <img src="{{ asset($item->product->product_image) }}" 
                                                     alt="{{ $item->product_title }}"
                                                     style="width: 30px; height: 30px; object-fit: cover; border-radius: 3px; margin-right: 10px;">
                                                @endif
                                                {{ $item->product_title }}
                                            </td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                            <td>${{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                                            <td>${{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Shipping:</strong></td>
                                            <td>${{ number_format($order->shipping, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                            <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <hr>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Order
                                </button>
                                <a href="{{ route('orders.view') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection