@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Products</h2>
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

         <!-- Search Products -->

        <!-- Search Form Section - Add this in your index.blade.php file -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="block">
                    <div class="title"><strong>Search Products</strong></div>
                    <div class="block-body">
                        <form action="{{ route('products.search') }}" method="GET" class="form-inline">
                            @csrf

                            <div class="form-group mr-3 mb-2">
                                <label for="search_type" class="sr-only">Search Type</label>
                                <select name="search_type" id="search_type" class="form-control">
                                    <option value="product_title"
                                        {{ request('search_type') == 'product_title' ? 'selected' : '' }}>Product Title
                                    </option>
                                    <option value="product_description"
                                        {{ request('search_type') == 'product_description' ? 'selected' : '' }}>Product
                                        Description</option>
                                    <option value="product_category"
                                        {{ request('search_type') == 'product_category' ? 'selected' : '' }}>Product
                                        Category</option>
                                </select>
                            </div>

                            <div class="form-group mr-3 mb-2" style="flex-grow: 1;">
                                <label for="search" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    placeholder="Enter search keyword..." value="{{ request('search') }}">
                            </div>

                            <button type="submit" class="btn btn-primary mb-2 mr-2">
                                <i class="fa fa-search"></i> Search
                            </button>

                            @if(request()->has('search'))
                            <a href="{{ route('products.index') }}" class="btn btn-secondary mb-2">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                            @endif
                        </form>

                        <!-- Search Results Info -->
                        @if(request()->has('search') && request('search'))
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="fa fa-info-circle"></i>
                            Showing results for "<strong>{{ request('search') }}</strong>"
                            in
                            <strong>{{ ucfirst(str_replace('_', ' ', request('search_type', 'product_title'))) }}</strong>
                            | Total found: <strong>{{ $products->total() }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- End Search Products -->
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="title d-flex justify-content-between align-items-center">
                        <strong>All Products</strong>
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add New Product
                        </a>
                    </div>
                    <div class="block-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if($product->product_image)
                                            <img src="{{ asset($product->product_image) }}"
                                                alt="{{ $product->product_title }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @else
                                            <div
                                                style="width: 50px; height: 50px; background: #f8f9fa; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-image text-muted"></i>
                                            </div>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($product->product_title, 30) }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($product->product_description, 50) }}</td>
                                        <td>${{ number_format($product->product_price, 2) }}</td>
                                        <td>{{ $product->product_quantity }}</td>
                                        <td>{{ $product->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('products.delete', $product->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No products found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($products->hasPages())
                        <div class="mt-3">
                            {{ $products->links() }}
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
/* Search Form Styling */
.form-inline {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}

.form-inline .form-group {
    margin-bottom: 0;
}

.form-inline .form-control {
    min-width: 200px;
}

@media (max-width: 768px) {
    .form-inline .form-group {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .form-inline .form-control {
        width: 100%;
        min-width: auto;
    }
}

/* Alert styling for search results */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
    padding: 12px 20px;
    border-radius: 4px;
}
</style>
@endpush