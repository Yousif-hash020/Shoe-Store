@extends('admin.layouts.app')

@section('title', 'View Product')
@section('page-title', 'Product Details: ' . $product->name)

@section('content')
<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-admin-warning">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i>Product Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-2">{{ $product->name }}</h3>
                        <p class="text-muted mb-3">{{ $product->description }}</p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>SKU:</strong> {{ $product->sku }}
                            </div>
                            <div class="col-md-6">
                                <strong>Category:</strong> {{ $product->category }}
                            </div>
                        </div>

                        @if($product->brand)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Brand:</strong> {{ $product->brand }}
                            </div>
                            @if($product->size)
                            <div class="col-md-6">
                                <strong>Size:</strong> {{ $product->size }}
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Price:</strong>
                                @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-danger fw-bold ms-2">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Stock:</strong>
                                @if($product->stock_quantity <= 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($product->stock_quantity <= 10)
                                    <span class="badge bg-warning">{{ $product->stock_quantity }} left</span>
                                @else
                                    <span class="badge bg-success">{{ $product->stock_quantity }} in stock</span>
                                @endif
                            </div>
                        </div>

                        @if(!empty($product->colors))
                        <div class="mb-3">
                            <strong>Available Colors:</strong>
                            <div class="mt-2">
                                @php
                                    $colors = is_array($product->colors) ? $product->colors : json_decode($product->colors ?? '[]', true);
                                @endphp
                                @foreach($colors as $color)
                                    <span class="badge bg-secondary me-1">{{ $color }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($product->tags)
                        <div class="mb-3">
                            <strong>Tags:</strong>
                            <div class="mt-2">
                                @foreach(explode(',', $product->tags) as $tag)
                                    <span class="badge bg-info me-1">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                @if($product->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($product->status === 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Featured:</strong>
                                @if($product->is_featured)
                                    <span class="badge bg-warning">Yes</span>
                                @else
                                    <span class="badge bg-light text-dark">No</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="img-fluid rounded border">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded border"
                                 style="height: 200px;">
                                <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($product->image_gallery))
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-images me-2"></i>Product Gallery
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $gallery = is_array($product->image_gallery) ? $product->image_gallery : json_decode($product->image_gallery ?? '[]', true);
                    @endphp
                    @foreach($gallery as $imageUrl)
                        @if($imageUrl)
                        <div class="col-md-3 mb-3">
                            <img src="{{ $imageUrl }}" alt="Gallery Image"
                                 class="img-fluid rounded border"
                                 style="aspect-ratio: 1/1; object-fit: cover;">
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-admin-primary">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>

                    <button type="button" class="btn btn-admin-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>Delete Product
                    </button>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Product Details
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Created:</small><br>
                    <span>{{ $product->created_at->format('M d, Y \a\t g:i A') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Last Updated:</small><br>
                    <span>{{ $product->updated_at->format('M d, Y \a\t g:i A') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Product ID:</small><br>
                    <span>{{ $product->id }}</span>
                </div>

                @if($product->sale_price)
                <div class="mb-3">
                    <small class="text-muted">Discount:</small><br>
                    <span class="text-success fw-bold">
                        {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 1) }}% OFF
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
