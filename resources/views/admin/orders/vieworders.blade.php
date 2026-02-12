@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">All Orders</h2>
    </div>
</div>
@endsection

@section('content')
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <!-- Success Message -->
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

        <!-- Error Message -->
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
            <div class="col-lg-12">
                <div class="block">
                    <div class="title d-flex justify-content-between align-items-center">
                        <strong>Orders List</strong>
                        <div class="d-flex">
                            <form action="{{ route('orders.search') }}" method="GET" class="form-inline mr-2">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Search by order number or name" value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary ml-2">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="block-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Products & Sizes</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $order->order_number }}</strong>
                                            <br>
                                            <small class="text-muted">ID: {{ $order->id }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $order->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->email }}</small>
                                            <br>
                                            <span
                                                class="badge badge-{{ $order->customer_type == 'guest' ? 'warning' : 'info' }}">
                                                {{ ucfirst($order->customer_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->items->count() > 0)
                                            <div style="max-width: 250px;">
                                                @foreach($order->items as $item)
                                                <div class="d-flex align-items-start mb-2 pb-2 border-bottom">
                                                    @php
                                                    $product = App\Models\Product::find($item->product_id);
                                                    @endphp
                                                    <div class="mr-2">
                                                        @if($product && $product->product_image)
                                                        <img src="{{ asset($product->product_image) }}"
                                                            alt="{{ $item->product_title }}"
                                                            style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;">
                                                        @else
                                                        <div
                                                            style="width: 45px; height: 45px; background: #f8f9fa; border-radius: 4px;
                                                                      display: flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-box text-muted"></i>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <div style="font-size: 12px; font-weight: 600;">
                                                            {{ Str::limit($item->product_title, 30) }}</div>
                                                        <div class="d-flex justify-content-between">
                                                            <span style="font-size: 11px;">Qty:
                                                                {{ $item->quantity }}</span>
                                                            @if($item->size)
                                                            <span class="badge badge-info" style="font-size: 11px;">
                                                                <i class="fa fa-ruler"></i> {{ $item->size }}
                                                            </span>
                                                            @else
                                                            <span class="badge badge-secondary"
                                                                style="font-size: 11px;">No Size</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">{{ $order->items->count() }} item(s)</small>
                                            @else
                                            <span class="text-muted">No items</span>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="fa fa-phone"></i> {{ $order->phone }}
                                            <br>
                                            @if($order->user_id)
                                            <small class="text-muted">User ID: {{ $order->user_id }}</small>
                                            @endif
                                        </td>
                                        <td style="max-width: 200px;">
                                            <small>{{ Str::limit($order->address, 50) }}</small>
                                            @if($order->notes)
                                            <br>
                                            <small class="text-muted"><i>Note:
                                                    {{ Str::limit($order->notes, 30) }}</i></small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>${{ number_format($order->total, 2) }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                Sub: ${{ number_format($order->subtotal, 2) }} |
                                                Tax: ${{ number_format($order->tax, 2) }}
                                            </small>
                                        </td>
                                        <td>
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
                                            <br>
                                            <small class="text-muted">
                                                <span
                                                    class="badge badge-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </small>
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('d M, Y') }}
                                            <br>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical" role="group">
                                                <a href="{{ route('orders.edit', $order->id) }}"
                                                    class="btn btn-sm btn-warning mb-1" title="Edit Order">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ route('orders.update-status.form', $order->id) }}"
                                                    class="btn btn-sm btn-success" title="Update Status">
                                                    <i class="fa fa-sync-alt"></i> Status
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('order.invoice', $order->order_number) }}"
                                                class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-download"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <div class="py-4">
                                                <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                                                <h5>No orders found</h5>
                                                <p class="text-muted">There are no orders in the system yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Order Summary -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Orders</h6>
                                        <h3>{{ $stats['total_orders'] ?? $orders->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Revenue</h6>
                                        <h3>${{ number_format($stats['total_revenue'] ?? $orders->sum('total'), 2) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Pending Orders</h6>
                                        <h3>{{ $stats['pending_orders'] ?? $orders->where('status', 'pending')->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Guest Orders</h6>
                                        <h3>{{ $stats['guest_orders'] ?? $orders->where('customer_type', 'guest')->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="mt-3">
                            {{ $orders->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.table td {
    vertical-align: middle;
}

.badge-warning {
    background-color: #ffc107;
}

.badge-info {
    background-color: #17a2b8;
}

.badge-primary {
    background-color: #007bff;
}

.badge-success {
    background-color: #28a745;
}

.badge-danger {
    background-color: #dc3545;
}

.badge-secondary {
    background-color: #6c757d;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 14px;
    margin-bottom: 5px;
}

.card h3 {
    margin: 0;
    font-weight: bold;
}

.btn-group-vertical .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.border-bottom {
    border-bottom: 1px dashed #dee2e6;
}

.badge i {
    margin-right: 3px;
}
</style>
@endpush