@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h5 no-margin-bottom">Message Details</h2>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Messages
            </a>
        </div>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Message Content</h5>
                        <span class="{{ $message->status_badge }}">
                            {{ ucfirst($message->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $message->name }}</p>
                                <p><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ $message->phone ?: 'N/A' }}</p>
                                <p><strong>Date:</strong> {{ $message->formatted_date }}</p>
                            </div>
                        </div>
                        
                        @if($message->subject)
                        <div class="mb-3">
                            <strong>Subject:</strong>
                            <p>{{ $message->subject }}</p>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <strong>Message:</strong>
                            <div class="border p-3 bg-light rounded" style="white-space: pre-wrap;">
                                {{ $message->message }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>IP Address:</strong> {{ $message->ip_address }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>User Agent:</strong></p>
                                <small class="text-muted">{{ Str::limit($message->user_agent, 100) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Admin Actions</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.contacts.update', $message->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="status">Update Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="unread" {{ $message->status == 'unread' ? 'selected' : '' }}>Unread</option>
                                    <option value="read" {{ $message->status == 'read' ? 'selected' : '' }}>Read</option>
                                    <option value="replied" {{ $message->status == 'replied' ? 'selected' : '' }}>Replied</option>
                                    <option value="spam" {{ $message->status == 'spam' ? 'selected' : '' }}>Spam</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="admin_notes">Admin Notes (Optional)</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" 
                                    rows="4" placeholder="Add any notes or follow-up actions...">{{ old('admin_notes', $message->admin_notes) }}</textarea>
                            </div>
                            
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                
                                <a href="mailto:{{ $message->email }}?subject=RE: {{ $message->subject ?: 'Your Message' }}" 
                                   class="btn btn-success mr-2" target="_blank">
                                    <i class="fa fa-reply"></i> Reply via Email
                                </a>
                                
                                <form action="{{ route('admin.contacts.destroy', $message->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </form>
                        
                        @if($message->admin_notes)
                        <div class="mt-3">
                            <strong>Current Admin Notes:</strong>
                            <div class="border p-2 bg-light rounded">
                                {{ $message->admin_notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection