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
                                        <th>Products</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
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
                                            <div class="d-flex flex-wrap">
                                                @foreach($order->items as $item)
                                                <div class="mr-2 mb-2">
                                                    @php
                                                    $product = App\Models\Product::find($item->product_id);
                                                    @endphp
                                                    @if($product && $product->product_image)
                                                    <img src="{{ asset($product->product_image) }}"
                                                        alt="{{ $item->product_title }}"
                                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;"
                                                        title="{{ $item->product_title }} (Qty: {{ $item->quantity }})">
                                                    @else
                                                    <div style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 4px; 
                                                                  display: flex; align-items: center; justify-content: center;"
                                                        title="{{ $item->product_title }} (Qty: {{ $item->quantity }})">
                                                        <i class="fa fa-box text-muted"></i>
                                                    </div>
                                                    @endif
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
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('orders.edit', $order->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit Order">
                                                    Edit Order
                                                </a>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="updateStatus({{ $order->id }})" title="Update Status">
                                                    Update Status
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
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
                                        <h3>{{ $orders->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Revenue</h6>
                                        <h3>${{ number_format($orders->sum('total'), 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Pending Orders</h6>
                                        <h3>{{ $orders->where('status', 'pending')->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Guest Orders</h6>
                                        <h3>{{ $orders->where('customer_type', 'guest')->count() }}</h3>
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

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="form-group">
                        <label for="status">Order Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Payment Status</label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notes">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"
                            placeholder="Add any additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus(orderId) {
    // Fetch current order status
    fetch(`/admin/orders/${orderId}/status`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate modal fields
                document.getElementById('order_id').value = orderId;
                document.getElementById('status').value = data.order.status;
                document.getElementById('payment_status').value = data.order.payment_status;
                document.getElementById('admin_notes').value = data.order.admin_notes || '';

                // Set form action
                document.getElementById('statusForm').action = `/admin/orders/${orderId}/update-status`;

                // Show modal
                $('#statusModal').modal('show');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load order details.');
        });
}

// Handle form submission
document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#statusModal').modal('hide');
                location.reload();
            } else {
                alert(data.message || 'Failed to update status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update status.');
        });
});
</script>

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
</style>
@endpush