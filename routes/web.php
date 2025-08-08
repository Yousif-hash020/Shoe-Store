<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminAuthController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/products/filters', [ProductController::class, 'filters'])->name('products.filters');
Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('products.category');
Route::get('/products/brand/{brand}', [ProductController::class, 'brand'])->name('products.brand');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{product}/quick-view', [ProductController::class, 'quickView'])->name('product.quick-view');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User Dashboard/Profile Routes
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Protected Checkout Routes (require authentication)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Admin Authentication Routes (guests only)
Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Admin Routes (require admin authentication)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Debug route (remove in production)
    Route::get('/debug', function() {
        return response()->json([
            'user' => auth()->user(),
            'is_admin' => auth()->user()->is_admin,
            'routes' => [
                'users.create' => route('admin.users.create'),
                'products.create' => route('admin.products.create'),
            ]
        ]);
    })->name('debug');

    // Troubleshooting page (remove in production)
    Route::get('/troubleshoot', function() {
        return view('admin.troubleshoot');
    })->name('troubleshoot');

    // User Management
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/verify', [AdminUserController::class, 'verify'])->name('users.verify');
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('users.bulk-action');
    Route::get('users/export', [AdminUserController::class, 'export'])->name('users.export');

    // Product Management
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{product}/update-stock', [AdminProductController::class, 'updateStock'])->name('products.update-stock');
    Route::post('products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
    Route::post('products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::get('products/export', [AdminProductController::class, 'export'])->name('products.export');
});
