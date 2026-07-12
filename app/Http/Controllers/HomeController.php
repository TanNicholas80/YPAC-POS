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
            ->with(['category', 'unit', 'images', 'specifications'])
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
                ->with(['category', 'unit', 'images', 'specifications'])
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
            ->with(['category', 'unit', 'images', 'specifications'])
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
            ->with(['category', 'unit', 'images', 'specifications'])
            ->get();

        $categories = ProductCategory::all();

        return view('products_catalog', compact('allProducts', 'categories'));
    }

    /**
     * Display the specified product details page (guest side).
     */
    public function productDetail($slug)
    {
        $product = Product::where('product_slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'unit', 'images', 'specifications'])
            ->firstOrFail();

        // Get 3 other related products for 'Temukan Produk Lainnya'
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->with(['category', 'unit', 'images'])
            ->take(3)
            ->get();

        return view('products_detail', compact('product', 'relatedProducts'));
    }

    /**
     * Display the About Us page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the Contact Us page.
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Process contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'topic' => 'required|string',
            'message' => 'required|string',
        ]);

        return redirect()->route('home.contact')->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}
