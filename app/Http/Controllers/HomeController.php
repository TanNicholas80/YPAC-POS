<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page with products.
     */
    public function index()
    {
        // 1. Get top 3 best-selling products (completed transactions)
        $topProducts = Product::where('is_active', true)
            ->withSum(['transactionDetails as total_sold' => function ($query) {
                $query->whereHas('transaction', function ($q) {
                    $q->where('status', 'completed');
                });
            }], 'qty')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();

        // If there are less than 3 products in the top-selling list, fallback to any active products
        if ($topProducts->count() < 3) {
            $existingIds = $topProducts->pluck('id')->toArray();
            $fillProducts = Product::where('is_active', true)
                ->whereNotIn('id', $existingIds)
                ->take(3 - count($existingIds))
                ->get();
            
            foreach ($fillProducts as $product) {
                $product->total_sold = 0;
            }

            $topProducts = $topProducts->concat($fillProducts);
        }

        // 2. Get all active products for the catalog
        $allProducts = Product::where('is_active', true)
            ->with(['category', 'unit'])
            ->get();

        // 3. Get all categories (optional, for filtering or display)
        $categories = ProductCategory::all();

        return view('landing', compact('topProducts', 'allProducts', 'categories'));
    }

    /**
     * Display the products catalog landing page.
     */
    public function products()
    {
        $allProducts = Product::where('is_active', true)
            ->with(['category', 'unit'])
            ->get();

        $categories = ProductCategory::all();

        return view('products_catalog', compact('allProducts', 'categories'));
    }
}
