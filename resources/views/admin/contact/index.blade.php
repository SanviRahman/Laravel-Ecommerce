@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Contact Messages Management</h2>
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

        <!-- Statistics Cards - Orders Page এর মতো -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Total Messages</h6>
                        <h3>{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">Unread</h6>
                        <h3>{{ $stats['unread'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">Read</h6>
                        <h3>{{ $stats['read'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Replied</h6>
                        <h3>{{ $stats['replied'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Today's</h6>
                        <h3>{{ $stats['today'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Block - Orders Page এর মতো -->
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="title d-flex justify-content-between align-items-center">
                        <strong>Contact Messages List</strong>
                        <div class="d-flex">
                            <!-- Search Form -->
                            <form action="{{ route('contacts.index') }}" method="GET" class="form-inline mr-2">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Search messages..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary ml-2">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </form>

                            <!-- Status Filter -->
                            <select name="status" class="form-control form-control-sm mr-2"
                                onchange="window.location.href='{{ route('contacts.index') }}?status='+this.value">
                                <option value="">All Status</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread
                                </option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied
                                </option>
                                <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam</option>
                            </select>

                            <!-- Clear Filters -->
                            @if(request('search') || request('status'))
                            <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fa fa-times"></i> Clear
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="block-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name & Contact</th>
                                        <th>Subject</th>
                                        <th>Message Preview</th>
                                        <th>Status</th>
                                        <th>Received</th>
                                        <th style="min-width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($messages as $message)
                                    <tr class="{{ $message->status == 'unread' ? 'table-warning' : '' }}">
                                        <td>{{ $loop->iteration + (($messages->currentPage() - 1) * $messages->perPage()) }}
                                        </td>
                                        <td>
                                            <strong>{{ $message->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa fa-envelope"></i>
                                                <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                            </small>
                                            @if($message->phone)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa fa-phone"></i> {{ $message->phone }}
                                            </small>
                                            @endif
                                            @if($message->ip_address)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa fa-globe"></i> {{ $message->ip_address }}
                                            </small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $message->subject ?: 'No Subject' }}</strong>
                                        </td>
                                        <td>
                                            <span title="{{ $message->message }}">
                                                {{ Str::limit($message->message, 80) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                            $statusClasses = [
                                            'unread' => 'warning',
                                            'read' => 'info',
                                            'replied' => 'success',
                                            'spam' => 'danger'
                                            ];
                                            @endphp
                                            <span
                                                class="badge badge-{{ $statusClasses[$message->status] ?? 'secondary' }}">
                                                {{ ucfirst($message->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>
                                                <i class="fa fa-calendar"></i>
                                                {{ $message->created_at->format('M d, Y') }}
                                                <br>
                                                <i class="fa fa-clock"></i> {{ $message->created_at->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical" role="group">
                                                <a href="{{ route('contacts.edit', $message->id) }}"
                                                    class="btn btn-sm btn-warning mb-1" title="Edit Status">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('contacts.destroy', $message->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                                        title="Delete Message">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="fa fa-envelope-open fa-4x text-muted mb-3"></i>
                                                <h5>No messages found</h5>
                                                <p class="text-muted">
                                                    @if(request('search') || request('status'))
                                                    No messages match your search criteria.
                                                    <br>
                                                    <a href="{{ route('contacts.index') }}"
                                                        class="btn btn-sm btn-primary mt-2">
                                                        Clear Filters
                                                    </a>
                                                    @else
                                                    No contact messages have been received yet.
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($messages->hasPages())
                        <div class="mt-3">
                            {{ $messages->links() }}
                        </div>
                        @endif

                        <div class="mt-3 text-muted small">
                            Showing {{ $messages->firstItem() ?? 0 }} to {{ $messages->lastItem() ?? 0 }}
                            of {{ $messages->total() }} total messages
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
/* Table Styles - vieworders.blade.php থেকে নেওয়া */
.table td {
    vertical-align: middle;
}

/* Badge Colors - vieworders.blade.php এর মতো */
.badge-warning {
    background-color: #ffc107;
    color: #856404;
}

.badge-info {
    background-color: #17a2b8;
    color: #fff;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-danger {
    background-color: #dc3545;
    color: #fff;
}

.badge-secondary {
    background-color: #6c757d;
    color: #fff;
}

.badge-primary {
    background-color: #007bff;
    color: #fff;
}

/* Card Styles - vieworders.blade.php এর মতো */
.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card .card-body {
    padding: 20px;
}

.card-title {
    font-size: 14px;
    margin-bottom: 5px;
    opacity: 0.9;
}

.card h3 {
    margin: 0;
    font-weight: bold;
    font-size: 28px;
}

/* Background Colors - vieworders.blade.php এর মতো */
.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.bg-secondary {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

/* Button Group - vieworders.blade.php এর মতো */
.btn-group-vertical {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.btn-group-vertical .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 4px !important;
    border: none;
    transition: all 0.3s ease;
    text-align: left;
}

.btn-group-vertical .btn:hover {
    transform: translateX(3px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-warning {
    background: linear-gradient(135deg, #f6c23e, #f4b619);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #e74a3b, #be2617);
    color: white;
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: white;
    border: none;
}

.btn-secondary {
    background: linear-gradient(135deg, #858796, #60616f);
    color: white;
    border: none;
}

.btn-info {
    background: linear-gradient(135deg, #36b9cc, #258391);
    color: white;
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #1cc88a, #169b6b);
    color: white;
    border: none;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

/* Form Controls - vieworders.blade.php এর মতো */
.form-control-sm {
    height: 35px;
    border-radius: 4px;
    border: 1px solid #d1d3e2;
    font-size: 13px;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

/* Alert Styles - vieworders.blade.php এর মতো */
.alert {
    border: none;
    border-radius: 8px;
    padding: 15px 20px;
    font-size: 14px;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

/* Block Styles - vieworders.blade.php এর মতো */
.block {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    overflow: hidden;
}

.block .title {
    padding: 20px 25px;
    background: linear-gradient(135deg, #f8f9fc, #f1f4f9);
    border-bottom: 1px solid #e3e6f0;
    font-size: 16px;
    font-weight: 600;
    color: #4e73df;
}

.block-body {
    padding: 25px;
}

/* Table Styles - vieworders.blade.php এর মতো */
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}

.table thead th {
    font-weight: 600;
    background-color: #f8f9fc;
    border-bottom: 2px solid #e3e6f0;
    padding: 12px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #4e73df;
}

.table td {
    padding: 15px 12px;
    border-bottom: 1px solid #edf2f9;
    font-size: 13px;
}

.table tbody tr:hover {
    background-color: #f8f9fc;
    transition: all 0.2s;
}

.table-warning {
    background-color: #fff3cd !important;
}

.table-warning:hover {
    background-color: #ffe69c !important;
}

/* Pagination - vieworders.blade.php এর মতো */
.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.pagination .page-link {
    padding: 8px 15px;
    color: #4e73df;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 5px !important;
    transition: all 0.2s;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: white;
    border-color: transparent;
    box-shadow: 0 2px 5px rgba(78, 115, 223, 0.3);
}

.pagination .page-link:hover {
    background: #f8f9fc;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Text utilities */
.text-muted {
    color: #6c757d !important;
}

.small {
    font-size: 85%;
}

/* Border styles */
.border-bottom {
    border-bottom: 1px dashed #dee2e6 !important;
}

.badge i {
    margin-right: 3px;
}

/* Responsive - vieworders.blade.php এর মতো */
@media (max-width: 768px) {
    .title {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .title .d-flex {
        margin-top: 10px;
        width: 100%;
        flex-wrap: wrap;
    }

    .form-inline {
        width: 100%;
        margin-right: 0 !important;
        margin-bottom: 10px;
    }

    .form-inline .form-group {
        width: 100%;
        margin-right: 0 !important;
    }

    .form-control-sm {
        width: 100% !important;
        margin-bottom: 5px;
    }

    select.form-control-sm {
        width: 100% !important;
        margin-right: 0 !important;
        margin-bottom: 5px;
    }

    .btn-group-vertical {
        flex-direction: row;
    }

    .btn-group-vertical .btn {
        margin-bottom: 0 !important;
        margin-right: 5px;
    }

    .btn-group-vertical .btn:hover {
        transform: translateY(-2px);
    }

    .card h3 {
        font-size: 22px;
    }
}
</style>
@endpush