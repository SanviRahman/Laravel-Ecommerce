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