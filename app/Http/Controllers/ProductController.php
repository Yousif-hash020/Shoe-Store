<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display the products page with filtering and search.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Product::active(); // Only show active products to public

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->search($search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->get('category'));
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->byBrand($request->get('brand'));
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->get('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->get('price_max'));
        }

        // Filter by availability
        if ($request->filled('in_stock')) {
            $query->inStock();
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->featured();
        }

        // Sort options
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('rating', 'desc');
                break;
            case 'name':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Get filter data
        $categories = Product::active()->distinct()->pluck('category')->filter()->sort();
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort();
        $featured = Product::active()->featured()->limit(8)->get();

        return view('products.index', compact('products', 'categories', 'brands', 'featured'));
    }

    /**
     * Display a specific product.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->active()->firstOrFail();

        // Get related products (same category, different product)
        $relatedProducts = Product::active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        // Get recently viewed products from session
        $recentlyViewed = session()->get('recently_viewed', []);

        // Add current product to recently viewed (max 5 items)
        if (!in_array($product->id, $recentlyViewed)) {
            array_unshift($recentlyViewed, $product->id);
            $recentlyViewed = array_slice($recentlyViewed, 0, 5);
            session()->put('recently_viewed', $recentlyViewed);
        }

        // Get recently viewed products
        $recentProducts = Product::active()
            ->whereIn('id', array_slice($recentlyViewed, 1)) // Exclude current product
            ->get();

        return view('products.show', compact('product', 'relatedProducts', 'recentProducts'));
    }

    /**
     * Get products by category
     */
    public function category($category)
    {
        $products = Product::active()
            ->byCategory($category)
            ->orderBy('name')
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }

    /**
     * Get products by brand
     */
    public function brand($brand)
    {
        $products = Product::active()
            ->byBrand($brand)
            ->orderBy('name')
            ->paginate(12);

        return view('products.brand', compact('products', 'brand'));
    }

    /**
     * Search products (AJAX endpoint)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->search($query)
            ->limit(10)
            ->get(['id', 'name', 'slug', 'price', 'image_url']);

        return response()->json($products);
    }

    /**
     * Get featured products (AJAX endpoint)
     */
    public function featured()
    {
        $products = Product::active()
            ->featured()
            ->limit(8)
            ->get();

        return response()->json($products);
    }

    /**
     * Get product filters data
     */
    public function filters()
    {
        $categories = Product::active()->distinct()->pluck('category')->filter()->sort()->values();
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort()->values();
        $priceRange = [
            'min' => Product::active()->min('price'),
            'max' => Product::active()->max('price')
        ];

        return response()->json([
            'categories' => $categories,
            'brands' => $brands,
            'price_range' => $priceRange
        ]);
    }

    /**
     * Get product quick view data (AJAX endpoint)
     */
    public function quickView(Product $product)
    {
        // Only show active products
        if (!$product->is_active || $product->status !== 'active') {
            abort(404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->short_description ?? substr($product->description, 0, 200) . '...',
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'formatted_price' => $product->formatted_price,
            'formatted_sale_price' => $product->formatted_sale_price,
            'is_on_sale' => $product->is_on_sale,
            'image_url' => $product->image_url,
            'image_gallery' => $product->image_gallery,
            'colors' => $product->colors,
            'size' => $product->size,
            'stock_quantity' => $product->stock_quantity,
            'is_in_stock' => $product->stock_quantity > 0,
            'rating' => $product->rating,
            'reviews_count' => $product->reviews_count
        ]);
    }
}
