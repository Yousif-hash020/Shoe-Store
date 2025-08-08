<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes (no authentication required)
Route::prefix('v1')->group(function () {

    // Product Public API
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/search', [ProductController::class, 'search']);
        Route::get('/featured', [ProductController::class, 'featured']);
        Route::get('/categories', [ProductController::class, 'categories']);
        Route::get('/brands', [ProductController::class, 'brands']);
        Route::get('/stats', [ProductController::class, 'stats']);
        Route::get('/{product}', [ProductController::class, 'show']);
    });

    // User Public API (limited access)
    Route::prefix('users')->group(function () {
        Route::get('/stats', [UserController::class, 'stats']);
    });
});

// Protected API Routes (authentication required)
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {

    // Admin User Management API
    Route::prefix('admin')->middleware('admin')->group(function () {

        // Users CRUD
        Route::apiResource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus']);

        // Products CRUD
        Route::apiResource('products', ProductController::class);
        Route::post('products/{product}/update-stock', [ProductController::class, 'updateStock']);

    });

    // General authenticated user routes
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'show']);
        Route::put('/profile', [UserController::class, 'update']);
    });
});
