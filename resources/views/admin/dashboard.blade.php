@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Welcome back, {{ Auth::user()->name }}!
                    </h4>
                </div>
                <div class="card-body">
                    <p class="mb-0">Manage your application with ease using this comprehensive admin panel.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['total_users'] }}</h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['total_products'] }}</h3>
                        <p class="text-muted mb-0">Total Products</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['active_products'] }}</h3>
                        <p class="text-muted mb-0">Active Products</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3" style="background: linear-gradient(135deg, #f39c12 0%, #d68910 100%);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['out_of_stock'] }}</h3>
                        <p class="text-muted mb-0">Out of Stock</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-admin-success btn-sm">
                            <i class="fas fa-user-plus me-1"></i>New User
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-admin-success btn-sm">
                            <i class="fas fa-plus me-1"></i>New Product
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-admin-success w-100 text-decoration-none py-3" style="border: 3px solid #27ae60;">
                                <i class="fas fa-user-plus d-block mb-2" style="font-size: 2rem;"></i>
                                <strong style="font-size: 1.2rem;">ADD USER</strong><br>
                                <small>Create new account</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-admin-success w-100 text-decoration-none py-3" style="border: 3px solid #27ae60;">
                                <i class="fas fa-plus-circle d-block mb-2" style="font-size: 2rem;"></i>
                                <strong style="font-size: 1.2rem;">ADD PRODUCT</strong><br>
                                <small>Create new product</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-admin-primary w-100 text-decoration-none py-3">
                                <i class="fas fa-users-cog d-block mb-2" style="font-size: 1.5rem;"></i>
                                <strong>Manage Users</strong><br>
                                <small>View all users</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-admin-primary w-100 text-decoration-none py-3">
                                <i class="fas fa-boxes d-block mb-2" style="font-size: 1.5rem;"></i>
                                <strong>Manage Products</strong><br>
                                <small>View all products</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Recent Products
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($stats['recent_products']) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_products'] as $product)
                                        <tr>
                                            <td><strong>{{ $product->name }}</strong></td>
                                            <td>{{ $product->category }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                @if($product->stock_quantity <= 0)
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @elseif($product->stock_quantity <= 10)
                                                    <span class="badge bg-warning">Low Stock ({{ $product->stock_quantity }})</span>
                                                @else
                                                    <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($product->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 mb-2">No products yet</h5>
                            <p class="mb-3 text-muted">Start by adding your first product!</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary">
                                <i class="fas fa-plus me-2"></i>Add Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>Recent Users
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($stats['recent_users']) > 0)
                        @foreach($stats['recent_users'] as $user)
                            <div class="d-flex align-items-center mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $user->name }}</h6>
                                    <p class="text-muted mb-0 small">{{ $user->email }}</p>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-admin-primary btn-sm">
                                <i class="fas fa-users me-2"></i>View All Users
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                            <h6 class="mt-3 mb-2">No users yet</h6>
                            <p class="mb-0 text-muted">Users will appear here when they register</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
