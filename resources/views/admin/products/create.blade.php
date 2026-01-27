@extends('admin.main')

@section('page-header')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Add New Product</h2>
    </div>
</div>
@endsection

@section('content')
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="title"><strong>Add Product</strong></div>
                    <div class="block-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Product Title -->
                                    <div class="form-group">
                                        <label for="product_title" class="form-control-label">Product Title *</label>
                                        <input type="text" id="product_title" name="product_title"
                                            class="form-control @error('product_title') is-invalid @enderror"
                                            value="{{ old('product_title') }}" placeholder="Enter product title"
                                            required>
                                        @error('product_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Product Description -->
                                    <div class="form-group">
                                        <label for="product_description" class="form-control-label">Product Description
                                            *</label>
                                        <textarea id="product_description" name="product_description"
                                            class="form-control @error('product_description') is-invalid @enderror"
                                            rows="5" placeholder="Enter product description"
                                            required>{{ old('product_description') }}</textarea>
                                        @error('product_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Product Category -->
                                    <div class="form-group">
                                        <label for="product_category" class="form-control-label">Category *</label>
                                        <select id="product_category" name="product_category"
                                            class="form-control @error('product_category') is-invalid @enderror"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('product_category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('product_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- Product Price -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_price" class="form-control-label">Price ($)
                                                    *</label>
                                                <input type="number" step="0.01" id="product_price" name="product_price"
                                                    class="form-control @error('product_price') is-invalid @enderror"
                                                    value="{{ old('product_price') }}" placeholder="0.00" required>
                                                @error('product_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Product Quantity -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_quantity" class="form-control-label">Quantity
                                                    *</label>
                                                <input type="number" id="product_quantity" name="product_quantity"
                                                    class="form-control @error('product_quantity') is-invalid @enderror"
                                                    value="{{ old('product_quantity') }}" placeholder="0" min="0"
                                                    required>
                                                @error('product_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Product Image -->
                                    <div class="form-group">
                                        <label for="product_image" class="form-control-label">Product Image</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('product_image') is-invalid @enderror"
                                                id="product_image" name="product_image" accept="image/*">
                                            <label class="custom-file-label" for="product_image">Choose file</label>
                                            @error('product_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <pre></pre>
                                        <small class="form-text text-muted">
                                            Recommended size: 500x500px, Max size: 12MB
                                        </small>
                                        <div class="mt-3 image-preview" id="imagePreview" style="display: none;">
                                            <img id="previewImage" src="" alt="Preview"
                                                style="width: 200px; height: 200px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Product
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
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

@push('styles')
<style>
/* Form Specific Styles */
.form-control-label {
    font-weight: 600;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 10px 15px;
    font-size: 14px;
    transition: all 0.3s;
    height: 45px;
    width: 100%;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    outline: none;
}

textarea.form-control {
    height: auto;
    min-height: 120px;
    resize: vertical;
}

select.form-control {
    height: 45px;
    cursor: pointer;
}

.custom-file-input {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 45px;
    margin: 0;
    opacity: 0;
    cursor: pointer;
}

.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: 45px;
    padding: 10px 15px;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    cursor: pointer;
}

.custom-file-label::after {
    content: "Browse";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    display: block;
    height: 43px;
    padding: 10px 15px;
    line-height: 1.5;
    color: #495057;
    background-color: #e9ecef;
    border-left: inherit;
    border-radius: 0 4px 4px 0;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

.form-control.is-invalid,
.custom-file-input.is-invalid~.custom-file-label {
    border-color: #dc3545;
}

.form-group {
    margin-bottom: 20px;
}

.text-muted {
    color: #6c757d !important;
    font-size: 12px;
}
</style>
@endpush

@push('scripts')
<script>
// Image preview functionality
document.getElementById('product_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imagePreview');
    const label = document.querySelector('.custom-file-label');

    if (file) {
        // Update file label
        label.textContent = file.name;

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        label.textContent = 'Choose file';
        previewContainer.style.display = 'none';
    }
});
</script>
@endpush