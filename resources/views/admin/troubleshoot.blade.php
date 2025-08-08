@extends('admin.layouts.app')

@section('title', 'Troubleshooting')
@section('page-title', 'Troubleshooting - CREATE Operations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-wrench me-2"></i>CREATE Operations Test
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>User Creation Test</h6>
                        <div class="mb-3">
                            <strong>Current User:</strong> {{ auth()->user()->name }}<br>
                            <strong>Is Admin:</strong> {{ auth()->user()->is_admin ? 'Yes' : 'No' }}<br>
                            <strong>User ID:</strong> {{ auth()->user()->id }}
                        </div>

                        <div class="mb-3">
                            <strong>Routes Test:</strong><br>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm mb-2">
                                <i class="fas fa-user-plus me-1"></i>Test User Create Page
                            </a><br>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-users me-1"></i>Users Index
                            </a>
                        </div>

                        <form id="testUserForm" action="{{ route('admin.users.store') }}" method="POST" class="border p-3 rounded">
                            @csrf
                            <h6>Quick User Test Form</h6>
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Full Name" value="Test User {{ rand(100, 999) }}" required>
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" value="test{{ rand(100, 999) }}@example.com" required>
                            </div>
                            <div class="mb-2">
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Password" value="password123" required>
                            </div>
                            <div class="mb-2">
                                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm Password" value="password123" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>Create Test User
                            </button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <h6>Product Creation Test</h6>
                        <div class="mb-3">
                            <strong>Product Model:</strong> {{ class_exists('App\Models\Product') ? 'Exists' : 'Missing' }}<br>
                            <strong>Products Table:</strong> {{ DB::connection()->getSchemaBuilder()->hasTable('products') ? 'Exists' : 'Missing' }}<br>
                            <strong>Total Products:</strong> {{ App\Models\Product::count() }}
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm mb-2">
                                <i class="fas fa-plus me-1"></i>Test Product Create Page
                            </a><br>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-box me-1"></i>Products Index
                            </a>
                        </div>

                        <form id="testProductForm" action="{{ route('admin.products.store') }}" method="POST" class="border p-3 rounded">
                            @csrf
                            <h6>Quick Product Test Form</h6>
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Product Name" value="Test Product {{ rand(100, 999) }}" required>
                            </div>
                            <div class="mb-2">
                                <input type="text" name="sku" class="form-control form-control-sm" placeholder="SKU" value="TEST-{{ rand(1000, 9999) }}" required>
                            </div>
                            <div class="mb-2">
                                <textarea name="description" class="form-control form-control-sm" placeholder="Description" rows="2" required>This is a test product description.</textarea>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="price" class="form-control form-control-sm" placeholder="Price" value="99.99" step="0.01" required>
                                </div>
                                <div class="col-6">
                                    <input type="number" name="stock_quantity" class="form-control form-control-sm" placeholder="Stock" value="10" required>
                                </div>
                            </div>
                            <div class="mt-2">
                                <select name="category" class="form-select form-select-sm" required>
                                    <option value="">Select Category</option>
                                    <option value="Men's Sneakers">Men's Sneakers</option>
                                    <option value="Women's Sneakers">Women's Sneakers</option>
                                    <option value="Running Shoes">Running Shoes</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-1"></i>Create Test Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6>System Information</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Laravel Version:</strong></td>
                                    <td>{{ app()->version() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>PHP Version:</strong></td>
                                    <td>{{ PHP_VERSION }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Environment:</strong></td>
                                    <td>{{ app()->environment() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Debug Mode:</strong></td>
                                    <td>{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Database Connection:</strong></td>
                                    <td>{{ config('database.default') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CSRF Token:</strong></td>
                                    <td>{{ csrf_token() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add form submission logging
    document.getElementById('testUserForm').addEventListener('submit', function(e) {
        console.log('User test form submitted');
        console.log('Form data:', new FormData(this));
    });

    document.getElementById('testProductForm').addEventListener('submit', function(e) {
        console.log('Product test form submitted');
        console.log('Form data:', new FormData(this));
    });
});
</script>
@endpush
