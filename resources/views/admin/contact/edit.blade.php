@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Edit Message Status</h2>
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
                        <strong>Edit Message #{{ $message->id }}</strong>
                        <div class="float-right">
                            <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="block-body">
                        <form action="{{ route('contacts.update', $message->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Name</label>
                                        <input type="text" class="form-control" value="{{ $message->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $message->email }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Phone</label>
                                        <input type="text" class="form-control" value="{{ $message->phone ?? 'N/A' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Subject</label>
                                        <input type="text" class="form-control" value="{{ $message->subject ?? 'No Subject' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Message</label>
                                <textarea class="form-control" rows="5" readonly>{{ $message->message }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="unread" {{ $message->status == 'unread' ? 'selected' : '' }}>Unread</option>
                                            <option value="read" {{ $message->status == 'read' ? 'selected' : '' }}>Read</option>
                                            <option value="replied" {{ $message->status == 'replied' ? 'selected' : '' }}>Replied</option>
                                            <option value="spam" {{ $message->status == 'spam' ? 'selected' : '' }}>Spam</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admin_notes">Admin Notes</label>
                                        <textarea name="admin_notes" id="admin_notes" rows="3" 
                                                  class="form-control" placeholder="Add any notes about this message...">{{ $message->admin_notes }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection