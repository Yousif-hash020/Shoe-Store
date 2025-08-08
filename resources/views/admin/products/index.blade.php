@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Product Management')

@section('content')
    <!-- Action Bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('admin.products.create') }}" class="btn btn-admin-success">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                       placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-admin-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="stock_filter" class="form-select">
                        <option value="">All Stock Levels</option>
                        <option value="in_stock" {{ request('stock_filter') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-admin-primary flex-fill">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="admin-card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-box me-2"></i>Products ({{ $products->total() }})
            </h5>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                 class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $product->sku }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $product->category }}</td>
                                    <td>
                                        @if($product->sale_price)
                                            <span class="text-decoration-line-through text-muted small">${{ number_format($product->price, 2) }}</span><br>
                                            <span class="text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                        @else
                                            <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->stock_quantity <= 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($product->stock_quantity <= 10)
                                            <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($product->status === 'inactive')
                                            <span class="badge bg-secondary">Inactive</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif

                                        @if($product->is_featured)
                                            <span class="badge bg-warning ms-1">Featured</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}"
                                               class="btn btn-sm btn-admin-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                               class="btn btn-sm btn-admin-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>


                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 mb-2">No Products Found</h4>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'category', 'status', 'stock_filter']))
                            No products match your current filters.
                        @else
                            Start by adding your first product to the store.
                        @endif
                    </p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-admin-success">
                        <i class="fas fa-plus me-2"></i>Add First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
