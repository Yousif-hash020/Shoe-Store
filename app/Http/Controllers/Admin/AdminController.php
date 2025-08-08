<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'featured_products' => Product::featured()->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_products' => Product::latest()->take(5)->get(),
            'low_stock_products' => Product::where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
