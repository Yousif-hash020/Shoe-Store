<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Only show active products for public API
        if (!$request->has('include_inactive')) {
            $query->active();
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->search($search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Filter by stock status
        if ($request->filled('in_stock')) {
            if ($request->boolean('in_stock')) {
                $query->inStock();
            } else {
                $query->outOfStock();
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            if ($request->boolean('featured')) {
                $query->featured();
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortOrder);
                break;
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'sku' => ['required', 'string', 'max:100', 'unique:products'],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:products'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'min_stock_level' => ['nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:100'],
            'size' => ['nullable', 'string', 'max:50'],
            'colors' => ['nullable', 'array'],
            'image_url' => ['nullable', 'url'],
            'image_gallery' => ['nullable', 'array'],
            'image_gallery.*' => ['url'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'status' => ['required', 'in:active,inactive,out_of_stock'],
            'tags' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'warranty_period' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Generate slug
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $data = $validator->validated();
            $data['slug'] = $slug;
            $data['is_featured'] = $request->boolean('is_featured', false);
            $data['is_active'] = $request->boolean('is_active', true);

            // Auto-set status based on stock
            if ($data['stock_quantity'] == 0) {
                $data['status'] = 'out_of_stock';
            }

            $product = Product::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Only show active products for public API unless specified
        if (!request()->has('include_inactive') && (!$product->is_active || $product->status !== 'active')) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->load(['createdBy:id,name', 'updatedBy:id,name']);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku,' . $product->id],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:products,barcode,' . $product->id],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'min_stock_level' => ['nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:100'],
            'size' => ['nullable', 'string', 'max:50'],
            'colors' => ['nullable', 'array'],
            'image_url' => ['nullable', 'url'],
            'image_gallery' => ['nullable', 'array'],
            'image_gallery.*' => ['url'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'status' => ['required', 'in:active,inactive,out_of_stock'],
            'tags' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'warranty_period' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $validator->validated();

            // Update slug if name changed
            if ($product->name !== $data['name']) {
                $slug = Str::slug($data['name']);
                $originalSlug = $slug;
                $counter = 1;

                while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $data['slug'] = $slug;
            }

            $data['is_featured'] = $request->boolean('is_featured', false);
            $data['is_active'] = $request->boolean('is_active', true);

            // Auto-set status based on stock
            if ($data['stock_quantity'] == 0) {
                $data['status'] = 'out_of_stock';
            }

            $product->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product statistics
     */
    public function stats()
    {
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
            'out_of_stock' => Product::where('status', 'out_of_stock')->count(),
            'featured' => Product::where('is_featured', true)->count(),
            'low_stock' => Product::lowStock()->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get categories
     */
    public function categories()
    {
        $categories = Product::active()->distinct()->pluck('category')->filter()->sort()->values();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get brands
     */
    public function brands()
    {
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort()->values();

        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Get featured products
     */
    public function featured(Request $request)
    {
        $limit = min($request->get('limit', 8), 20);

        $products = Product::active()->featured()->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        $products = Product::active()
            ->search($query)
            ->limit(20)
            ->get(['id', 'name', 'slug', 'price', 'sale_price', 'image_url']);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'action' => ['required', 'in:set,add,subtract'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $currentStock = $product->stock_quantity;
            $newStock = 0;

            switch ($request->action) {
                case 'set':
                    $newStock = $request->stock_quantity;
                    break;
                case 'add':
                    $newStock = $currentStock + $request->stock_quantity;
                    break;
                case 'subtract':
                    $newStock = max(0, $currentStock - $request->stock_quantity);
                    break;
            }

            $product->update(['stock_quantity' => $newStock]);

            // Auto-update status if needed
            if ($newStock == 0 && $product->status !== 'out_of_stock') {
                $product->update(['status' => 'out_of_stock']);
            } elseif ($newStock > 0 && $product->status === 'out_of_stock') {
                $product->update(['status' => 'active']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully',
                'data' => [
                    'old_stock' => $currentStock,
                    'new_stock' => $newStock,
                    'status' => $product->fresh()->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
