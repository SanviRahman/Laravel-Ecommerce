@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Update Order Status</h2>
    </div>
</div>
@endsection

@section('content')
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="block">
                    <div class="title">
                        <strong>Update Status for Order #{{ $order->order_number }}</strong>
                        <a href="{{ route('orders.edit', $order->id) }}"
                            class="btn btn-sm btn-warning float-right ml-2">
                            <i class="fa fa-edit"></i> Edit Order
                        </a>
                        <a href="{{ route('orders.view') }}" class="btn btn-sm btn-secondary float-right">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="block-body">
                        <!-- Order Summary -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Order Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Customer Information</h6>
                                        <p><strong>Name:</strong> {{ $order->name }}</p>
                                        <p><strong>Email:</strong> {{ $order->email }}</p>
                                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                                        <p><strong>Customer Type:</strong>
                                            <span
                                                class="badge badge-{{ $order->customer_type == 'guest' ? 'warning' : 'info' }}">
                                                {{ ucfirst($order->customer_type) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Order Details</h6>
                                        <p><strong>Current Status:</strong>
                                            @php
                                            $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                            ];
                                            $paymentColors = [
                                            'pending' => 'warning',
                                            'paid' => 'success',
                                            'failed' => 'danger'
                                            ];
                                            @endphp
                                            <span
                                                class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Payment Status:</strong>
                                            <span
                                                class="badge badge-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                        <p><strong>Total Amount:</strong> <strong
                                                class="text-primary">${{ number_format($order->total, 2) }}</strong></p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items with Sizes -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">Order Items</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Size</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product && $item->product->product_image)
                                                        <img src="{{ asset($item->product->product_image) }}"
                                                            alt="{{ $item->product_title }}"
                                                            style="width: 35px; height: 35px; object-fit: cover; border-radius: 4px; margin-right: 8px;">
                                                        @endif
                                                        <span>{{ Str::limit($item->product_title, 30) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($item->size)
                                                    <span class="badge badge-info">
                                                        <i class="fa fa-ruler"></i> {{ $item->size }}
                                                    </span>
                                                    @else
                                                    <span class="badge badge-secondary">-</span>
                                                    @endif
                                                </td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format($item->total, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                                <td>${{ number_format($order->subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Tax:</strong></td>
                                                <td>${{ number_format($order->tax, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Shipping:</strong></td>
                                                <td>${{ number_format($order->shipping, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                                <td><strong
                                                        class="text-primary">${{ number_format($order->total, 2) }}</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Status Update Form -->
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Update Status</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Order Status *</label>
                                                <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                    <option value="pending"
                                                        {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>
                                                        🟡 Pending</option>
                                                    <option value="processing"
                                                        {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>
                                                        🔵 Processing</option>
                                                    <option value="shipped"
                                                        {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>
                                                        📦 Shipped</option>
                                                    <option value="delivered"
                                                        {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>
                                                        ✅ Delivered</option>
                                                    <option value="cancelled"
                                                        {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                                                        ❌ Cancelled</option>
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_status">Payment Status *</label>
                                                <select
                                                    class="form-control @error('payment_status') is-invalid @enderror"
                                                    id="payment_status" name="payment_status" required>
                                                    <option value="pending"
                                                        {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>
                                                        ⏳ Pending</option>
                                                    <option value="paid"
                                                        {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>
                                                        💰 Paid</option>
                                                    <option value="failed"
                                                        {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>
                                                        ❌ Failed</option>
                                                </select>
                                                @error('payment_status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="admin_notes">Admin Notes (Optional)</label>
                                        <textarea class="form-control @error('admin_notes') is-invalid @enderror"
                                            id="admin_notes" name="admin_notes" rows="3"
                                            placeholder="Add any additional notes or comments about this status change...">{{ old('admin_notes') }}</textarea>
                                        <small class="form-text text-muted">
                                            <i class="fa fa-info-circle"></i> These notes will be visible in order
                                            history.
                                        </small>
                                        @error('admin_notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <hr>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check-circle"></i> Update Status
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
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: none;
    margin-bottom: 20px;
}

.card-header {
    border-bottom: none;
}

.badge-info {
    background-color: #17a2b8;
    padding: 5px 10px;
}

.badge-secondary {
    background-color: #6c757d;
    padding: 5px 10px;
}

.table td,
.table th {
    vertical-align: middle;
}
</style>
@endpush