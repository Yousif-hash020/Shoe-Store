<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Advanced search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->get('brand'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by stock level
        if ($request->filled('stock_filter')) {
            $stockFilter = $request->get('stock_filter');
            if ($stockFilter === 'low_stock') {
                $query->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0);
            } elseif ($stockFilter === 'out_of_stock') {
                $query->where('stock_quantity', 0);
            } elseif ($stockFilter === 'in_stock') {
                $query->where('stock_quantity', '>', 10);
            }
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->get('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->get('price_max'));
        }

        // Filter by featured products
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(15)->withQueryString();

        // Get filter options
        $categories = Product::distinct()->pluck('category')->filter()->sort();
        $brands = Product::distinct()->pluck('brand')->filter()->sort();
        $statuses = ['active', 'inactive', 'out_of_stock'];

        // Statistics
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'low_stock' => Product::where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
            'featured' => Product::where('is_featured', true)->count(),
            'recent' => Product::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];

        return view('admin.products.index', compact('products', 'categories', 'brands', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Product::distinct()->pluck('category')->filter()->sort();
        $brands = Product::distinct()->pluck('brand')->filter()->sort();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'min:10'],
                'short_description' => ['nullable', 'string', 'max:500'],
                'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
                'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
                'cost_price' => ['nullable', 'numeric', 'min:0'],
                'category' => ['required', 'string', 'max:100'],
                'brand' => ['nullable', 'string', 'max:100'],
                'sku' => ['required', 'string', 'max:100', 'unique:products', 'regex:/^[A-Z0-9-]+$/'],
                'barcode' => ['nullable', 'string', 'max:50', 'unique:products'],
                'stock_quantity' => ['required', 'integer', 'min:0'],
                'min_stock_level' => ['nullable', 'integer', 'min:0'],
                'weight' => ['nullable', 'numeric', 'min:0'],
                'dimensions' => ['nullable', 'string', 'max:100'],
                'size' => ['nullable', 'string', 'max:50'],
                'colors' => ['nullable', 'array'],
                'colors.*' => ['string', 'max:50'],
                'image_url' => ['nullable', 'url', 'max:500'],
                'image_gallery' => ['nullable', 'array'],
                'image_gallery.*' => ['url', 'max:500'],
                'is_featured' => ['boolean'],
                'is_active' => ['boolean'],
                'status' => ['required', 'in:active,inactive,out_of_stock'],
                'tags' => ['nullable', 'string', 'max:500'],
                'meta_title' => ['nullable', 'string', 'max:255'],
                'meta_description' => ['nullable', 'string', 'max:500'],
                'warranty_period' => ['nullable', 'string', 'max:100'],
            ], [
                'sku.regex' => 'SKU should only contain uppercase letters, numbers, and hyphens.',
                'price.max' => 'Price cannot exceed 999,999.99.',
                'description.min' => 'Description must be at least 10 characters long.',
            ]);

            // Generate slug from name
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure slug is unique
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $data = $validated;
            $data['slug'] = $slug;

            // Handle arrays
            $data['colors'] = $request->has('colors') && is_array($request->colors)
                ? array_filter($request->colors)
                : null;

            $data['image_gallery'] = $request->has('image_gallery') && is_array($request->image_gallery)
                ? array_filter($request->image_gallery)
                : null;

            // Set boolean values
            $data['is_featured'] = $request->boolean('is_featured', false);
            $data['is_active'] = $request->boolean('is_active', true);

            // Auto-set status based on stock
            if ($data['stock_quantity'] == 0) {
                $data['status'] = 'out_of_stock';
            }

            // Set created_by
            $data['created_by'] = auth()->id();

            $product = Product::create($data);

            DB::commit();

            Log::info('Product created successfully', [
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'created_by' => auth()->user()->email
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Product creation validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['createdBy', 'updatedBy']);

        // Product statistics and insights
        $stats = [
            'stock_status' => $this->getStockStatus($product->stock_quantity, $product->min_stock_level),
            'profit_margin' => $product->cost_price ? round((($product->price - $product->cost_price) / $product->price) * 100, 2) : null,
            'days_since_created' => $product->created_at->diffInDays(now()),
            'last_updated' => $product->updated_at->diffForHumans(),
        ];

        return view('admin.products.show', compact('product', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Product::distinct()->pluck('category')->filter()->sort();
        $brands = Product::distinct()->pluck('brand')->filter()->sort();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'min:10'],
                'short_description' => ['nullable', 'string', 'max:500'],
                'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
                'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
                'cost_price' => ['nullable', 'numeric', 'min:0'],
                'category' => ['required', 'string', 'max:100'],
                'brand' => ['nullable', 'string', 'max:100'],
                'sku' => ['required', 'string', 'max:100', 'unique:products,sku,' . $product->id, 'regex:/^[A-Z0-9-]+$/'],
                'barcode' => ['nullable', 'string', 'max:50', 'unique:products,barcode,' . $product->id],
                'stock_quantity' => ['required', 'integer', 'min:0'],
                'min_stock_level' => ['nullable', 'integer', 'min:0'],
                'weight' => ['nullable', 'numeric', 'min:0'],
                'dimensions' => ['nullable', 'string', 'max:100'],
                'size' => ['nullable', 'string', 'max:50'],
                'colors' => ['nullable', 'array'],
                'colors.*' => ['string', 'max:50'],
                'image_url' => ['nullable', 'url', 'max:500'],
                'image_gallery' => ['nullable', 'array'],
                'image_gallery.*' => ['url', 'max:500'],
                'is_featured' => ['boolean'],
                'is_active' => ['boolean'],
                'status' => ['required', 'in:active,inactive,out_of_stock'],
                'tags' => ['nullable', 'string', 'max:500'],
                'meta_title' => ['nullable', 'string', 'max:255'],
                'meta_description' => ['nullable', 'string', 'max:500'],
                'warranty_period' => ['nullable', 'string', 'max:100'],
            ], [
                'sku.regex' => 'SKU should only contain uppercase letters, numbers, and hyphens.',
                'price.max' => 'Price cannot exceed 999,999.99.',
                'description.min' => 'Description must be at least 10 characters long.',
            ]);

            $data = $validated;

            // Update slug if name changed
            if ($product->name !== $validated['name']) {
                $slug = Str::slug($validated['name']);
                $originalSlug = $slug;
                $counter = 1;

                while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $data['slug'] = $slug;
            }

            // Handle arrays
            $data['colors'] = $request->has('colors') && is_array($request->colors)
                ? array_filter($request->colors)
                : null;

            $data['image_gallery'] = $request->has('image_gallery') && is_array($request->image_gallery)
                ? array_filter($request->image_gallery)
                : null;

            // Set boolean values
            $data['is_featured'] = $request->boolean('is_featured', false);
            $data['is_active'] = $request->boolean('is_active', true);

            // Auto-set status based on stock
            if ($data['stock_quantity'] == 0) {
                $data['status'] = 'out_of_stock';
            }

            // Set updated_by
            $data['updated_by'] = auth()->id();

            $product->update($data);

            DB::commit();

            Log::info('Product updated successfully', [
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'updated_by' => auth()->user()->email
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Product update validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            $productName = $product->name;
            $productSku = $product->sku;

            $product->delete();

            DB::commit();

            Log::info('Product deleted successfully', [
                'product_name' => $productName,
                'product_sku' => $productSku,
                'deleted_by' => auth()->user()->email
            ]);

            return redirect()->route('admin.products.index')->with('success', "Product '{$productName}' deleted successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product deletion failed', ['error' => $e->getMessage()]);
            return redirect()->route('admin.products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    /**
     * Toggle product's active status
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->update(['is_active' => !$product->is_active]);

            $status = $product->is_active ? 'activated' : 'deactivated';

            Log::info("Product {$status}", [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'changed_by' => auth()->user()->email
            ]);

            return response()->json([
                'success' => true,
                'message' => "Product {$status} successfully!",
                'status' => $product->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Product status toggle failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to change product status'], 500);
        }
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'action' => ['required', 'in:set,add,subtract'],
        ]);

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

            Log::info('Product stock updated', [
                'product_id' => $product->id,
                'old_stock' => $currentStock,
                'new_stock' => $newStock,
                'action' => $request->action,
                'updated_by' => auth()->user()->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully!',
                'new_stock' => $newStock,
                'status' => $product->fresh()->status
            ]);

        } catch (\Exception $e) {
            Log::error('Stock update failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update stock'], 500);
        }
    }

    /**
     * Bulk actions for products
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:delete,activate,deactivate,feature,unfeature'],
            'products' => ['required', 'array', 'min:1'],
            'products.*' => ['exists:products,id'],
        ]);

        try {
            DB::beginTransaction();

            $productIds = $request->products;
            $action = $request->action;

            $products = Product::whereIn('id', $productIds)->get();
            $count = $products->count();

            switch ($action) {
                case 'delete':
                    Product::whereIn('id', $productIds)->delete();
                    $message = "{$count} products deleted successfully!";
                    break;

                case 'activate':
                    Product::whereIn('id', $productIds)->update(['is_active' => true]);
                    $message = "{$count} products activated successfully!";
                    break;

                case 'deactivate':
                    Product::whereIn('id', $productIds)->update(['is_active' => false]);
                    $message = "{$count} products deactivated successfully!";
                    break;

                case 'feature':
                    Product::whereIn('id', $productIds)->update(['is_featured' => true]);
                    $message = "{$count} products marked as featured successfully!";
                    break;

                case 'unfeature':
                    Product::whereIn('id', $productIds)->update(['is_featured' => false]);
                    $message = "{$count} products unmarked as featured successfully!";
                    break;
            }

            DB::commit();

            Log::info("Bulk action performed on products", [
                'action' => $action,
                'product_count' => $count,
                'performed_by' => auth()->user()->email
            ]);

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk action failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Export products data
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        $products = Product::select('id', 'name', 'sku', 'price', 'sale_price', 'category', 'brand', 'stock_quantity', 'status', 'is_featured', 'created_at')->get();

        if ($format === 'csv') {
            $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($products) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Name', 'SKU', 'Price', 'Sale Price', 'Category', 'Brand', 'Stock', 'Status', 'Featured', 'Created At']);

                foreach ($products as $product) {
                    fputcsv($file, [
                        $product->id,
                        $product->name,
                        $product->sku,
                        $product->price,
                        $product->sale_price ?? 'N/A',
                        $product->category,
                        $product->brand ?? 'N/A',
                        $product->stock_quantity,
                        $product->status,
                        $product->is_featured ? 'Yes' : 'No',
                        $product->created_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Invalid export format');
    }

    /**
     * Get stock status
     */
    private function getStockStatus($stock, $minLevel = 10)
    {
        if ($stock == 0) {
            return 'out_of_stock';
        } elseif ($stock <= $minLevel) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    /**
     * Duplicate a product
     */
    public function duplicate(Product $product)
    {
        try {
            DB::beginTransaction();

            $newProduct = $product->replicate();
            $newProduct->name = $product->name . ' (Copy)';
            $newProduct->sku = $this->generateUniqueSku($product->sku . '-COPY');
            $newProduct->slug = Str::slug($newProduct->name);
            $newProduct->created_by = auth()->id();
            $newProduct->updated_by = null;
            $newProduct->save();

            DB::commit();

            Log::info('Product duplicated successfully', [
                'original_product_id' => $product->id,
                'new_product_id' => $newProduct->id,
                'duplicated_by' => auth()->user()->email
            ]);

            return redirect()->route('admin.products.edit', $newProduct)->with('success', 'Product duplicated successfully! Please review and update as needed.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product duplication failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to duplicate product: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique SKU
     */
    private function generateUniqueSku($baseSku)
    {
        $sku = strtoupper($baseSku);
        $counter = 1;

        while (Product::where('sku', $sku)->exists()) {
            $sku = strtoupper($baseSku) . '-' . $counter++;
        }

        return $sku;
    }
}
