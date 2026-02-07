@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Contact Messages</h2>
    </div>
</div>
@endsection

@section('content')
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
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

        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="title d-flex justify-content-between align-items-center">
                        <strong>Contact Messages</strong>
                        <div class="d-flex">
                            <form action="{{ route('admin.contacts.index') }}" method="GET" class="form-inline mr-2">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Search messages..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary ml-2">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.contacts.mark-all-read') }}" method="POST" class="mr-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="fa fa-check-double"></i> Mark All Read
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Statistics Cards -->
                    <div class="row mt-3 mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total Messages</h6>
                                    <h3>{{ $stats['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Unread</h6>
                                    <h3>{{ $stats['unread'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Read</h6>
                                    <h3>{{ $stats['read'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Replied</h6>
                                    <h3>{{ $stats['replied'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Today</h6>
                                    <h3>{{ $stats['today'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($messages as $message)
                                    <tr class="{{ $message->status == 'unread' ? 'table-warning' : '' }}">
                                        <td>{{ $loop->iteration + (($messages->currentPage() - 1) * $messages->perPage()) }}</td>
                                        <td>
                                            <strong>{{ $message->name }}</strong>
                                            @if($message->phone)
                                            <br>
                                            <small class="text-muted">{{ $message->phone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                            @if($message->ip_address)
                                            <br>
                                            <small class="text-muted">IP: {{ $message->ip_address }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $message->subject ?: 'No Subject' }}
                                        </td>
                                        <td style="max-width: 250px;">
                                            {{ Str::limit($message->message, 100) }}
                                        </td>
                                        <td>
                                            <span class="{{ $message->status_badge }}">
                                                {{ ucfirst($message->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $message->formatted_date }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.contacts.show', $message->id) }}" 
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.contacts.destroy', $message->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div class="py-4">
                                                <i class="fa fa-envelope fa-3x text-muted mb-3"></i>
                                                <h5>No messages found</h5>
                                                <p class="text-muted">No contact messages have been received yet.</p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection