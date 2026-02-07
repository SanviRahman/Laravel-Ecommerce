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
                    </div>
                    <div class="block-body">
                        <!-- Order Summary -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Customer Information</h6>
                                        <p><strong>Name:</strong> {{ $order->name }}</p>
                                        <p><strong>Email:</strong> {{ $order->email }}</p>
                                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                                        <p><strong>Customer Type:</strong> 
                                            <span class="badge badge-{{ $order->customer_type == 'guest' ? 'warning' : 'info' }}">
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
                                            <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Payment Status:</strong> 
                                            <span class="badge badge-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                        <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Update Form -->
                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="status">Order Status *</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="payment_status">Payment Status *</label>
                                <select class="form-control @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                    <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                                @error('payment_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="admin_notes">Admin Notes (Optional)</label>
                                <textarea class="form-control @error('admin_notes') is-invalid @enderror" id="admin_notes" name="admin_notes" rows="4" 
                                    placeholder="Add any additional notes or comments...">{{ old('admin_notes') }}</textarea>
                                <small class="form-text text-muted">This note will be added to the order history.</small>
                                @error('admin_notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Status
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