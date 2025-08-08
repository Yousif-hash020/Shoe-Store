@extends('admin.layouts.app')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Add New Product
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" id="createProductForm">
                    @csrf

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-lg-8">
                            <h6 class="text-muted mb-3">Basic Information</h6>

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="sku" class="form-label">SKU *</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                           id="sku" name="sku" value="{{ old('sku') }}" required>
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-select @error('category') is-invalid @enderror"
                                            id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Men's Sneakers" {{ old('category') == "Men's Sneakers" ? 'selected' : '' }}>Men's Sneakers</option>
                                        <option value="Women's Sneakers" {{ old('category') == "Women's Sneakers" ? 'selected' : '' }}>Women's Sneakers</option>
                                        <option value="Running Shoes" {{ old('category') == 'Running Shoes' ? 'selected' : '' }}>Running Shoes</option>
                                        <option value="Basketball Shoes" {{ old('category') == 'Basketball Shoes' ? 'selected' : '' }}>Basketball Shoes</option>
                                        <option value="Casual Shoes" {{ old('category') == 'Casual Shoes' ? 'selected' : '' }}>Casual Shoes</option>
                                        <option value="Boots" {{ old('category') == 'Boots' ? 'selected' : '' }}>Boots</option>
                                        <option value="Sandals" {{ old('category') == 'Sandals' ? 'selected' : '' }}>Sandals</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror"
                                           id="brand" name="brand" value="{{ old('brand') }}">
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="size" class="form-label">Size</label>
                                    <input type="text" class="form-control @error('size') is-invalid @enderror"
                                           id="size" name="size" value="{{ old('size') }}" placeholder="e.g., 8, 9, 10">
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="price" class="form-label">Price ($) *</label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="sale_price" class="form-label">Sale Price ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror"
                                           id="sale_price" name="sale_price" value="{{ old('sale_price') }}">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Colors -->
                            <div class="mb-3">
                                <label class="form-label">Available Colors</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Black" id="color_black">
                                            <label class="form-check-label" for="color_black">Black</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="White" id="color_white">
                                            <label class="form-check-label" for="color_white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Red" id="color_red">
                                            <label class="form-check-label" for="color_red">Red</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Blue" id="color_blue">
                                            <label class="form-check-label" for="color_blue">Blue</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Green" id="color_green">
                                            <label class="form-check-label" for="color_green">Green</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Yellow" id="color_yellow">
                                            <label class="form-check-label" for="color_yellow">Yellow</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Brown" id="color_brown">
                                            <label class="form-check-label" for="color_brown">Brown</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colors[]" value="Gray" id="color_gray">
                                            <label class="form-check-label" for="color_gray">Gray</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                       id="tags" name="tags" value="{{ old('tags') }}"
                                       placeholder="e.g., casual, sport, limited edition">
                                <small class="form-text text-muted">Separate tags with commas</small>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Images and Settings -->
                        <div class="col-lg-4">
                            <h6 class="text-muted mb-3">Images & Settings</h6>

                            <div class="mb-3">
                                <label for="image_url" class="form-label">Main Image URL</label>
                                <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                       id="image_url" name="image_url" value="{{ old('image_url') }}">
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gallery Images</label>
                                <div id="gallery-container">
                                    <div class="input-group mb-2">
                                        <input type="url" class="form-control" name="image_gallery[]" placeholder="Image URL">
                                        <button type="button" class="btn btn-outline-secondary" onclick="addGalleryImage()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                           id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Featured Product
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                           id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Products
                        </a>
                        <button type="submit" class="btn btn-admin-success" id="createProductBtn">
                            <i class="fas fa-save me-2"></i>Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createProductForm');
    const submitBtn = document.getElementById('createProductBtn');

    form.addEventListener('submit', function(e) {
        console.log('Product form is being submitted...');

        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Product...';

        // Re-enable button after 5 seconds in case of issues
        setTimeout(function() {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Create Product';
            }
        }, 5000);
    });

    // Add real-time validation feedback
    const requiredFields = ['name', 'sku', 'description', 'price', 'category', 'stock_quantity', 'status'];
    requiredFields.forEach(function(fieldName) {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });

    // Price validation
    const priceField = document.getElementById('price');
    const salePriceField = document.getElementById('sale_price');

    if (salePriceField && priceField) {
        salePriceField.addEventListener('blur', function() {
            const price = parseFloat(priceField.value);
            const salePrice = parseFloat(this.value);

            if (this.value && salePrice >= price) {
                this.classList.add('is-invalid');
                this.nextElementSibling?.remove();
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'Sale price must be less than regular price.';
                this.after(feedback);
            } else {
                this.classList.remove('is-invalid');
                this.nextElementSibling?.remove();
            }
        });
    }
});

function addGalleryImage() {
    const container = document.getElementById('gallery-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="url" class="form-control" name="image_gallery[]" placeholder="Image URL">
        <button type="button" class="btn btn-outline-danger" onclick="removeGalleryImage(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeGalleryImage(button) {
    button.parentElement.remove();
}
</script>
@endpush
