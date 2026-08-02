<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Services\MailtrapService;

class HomeController extends Controller
{
    /**
     * Display the landing page with products.
     */
    public function index()
    {
        // Set SEO Meta
        SEOTools::setTitle('KUBE YPAC - Produk Kreatif Karya Anak Disabilitas');
        SEOTools::setDescription('Dukung kemandirian siswa disabilitas dengan berbelanja kerajinan tangan, kudapan lezat, dan karya seni buatan siswa di KUBE YPAC.');
        SEOTools::setCanonical(url('/'));
        SEOTools::opengraph()->setUrl(url('/'));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage(asset('images/LogoYPAC.png'));
        SEOTools::twitter()->setSite('@KubeYpac');

        // 1. Get top 3 best-selling products (completed transactions)
        $topProducts = Product::where('is_active', true)
            ->with(['category', 'unit', 'images', 'specifications', 'variants'])
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
                ->with(['category', 'unit', 'images', 'specifications', 'variants'])
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
            ->with(['category', 'unit', 'images', 'specifications', 'variants'])
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
        // Set SEO Meta
        SEOTools::setTitle('Katalog Produk Kreatif - KUBE YPAC');
        SEOTools::setDescription('Telusuri berbagai kerajinan tangan, kudapan kuliner, dan karya seni unik buatan siswa disabilitas YPAC. Dibuat dengan penuh dedikasi.');
        SEOTools::setCanonical(route('home.products'));
        SEOTools::opengraph()->setUrl(route('home.products'));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage(asset('images/LogoYPAC.png'));
        SEOTools::twitter()->setSite('@KubeYpac');

        $allProducts = Product::where('is_active', true)
            ->with(['category', 'unit', 'images', 'specifications', 'variants'])
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
            ->with(['category', 'unit', 'images', 'specifications', 'variants'])
            ->firstOrFail();

        // Dynamic SEO Configuration
        $mainImage = $product->images->first() 
            ? (str_starts_with($product->images->first()->image_path, 'http') 
                ? $product->images->first()->image_path 
                : asset($product->images->first()->image_path))
            : asset('images/LogoYPAC.png');

        SEOTools::setTitle($product->product_name . ' - KUBE YPAC');
        SEOTools::setDescription("Beli {$product->product_name} berkualitas tinggi di KUBE YPAC. Harga: Rp " . number_format($product->price, 0, ',', '.') . ". Karya kreatif luar biasa siswa disabilitas.");
        SEOTools::setCanonical(route('home.product.detail', $product->product_slug));
        SEOTools::opengraph()->setUrl(route('home.product.detail', $product->product_slug));
        SEOTools::opengraph()->addProperty('type', 'og:product');
        SEOTools::opengraph()->addImage($mainImage);
        SEOTools::twitter()->setSite('@KubeYpac');

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
        // Set SEO Meta
        SEOTools::setTitle('Tentang Kami - KUBE YPAC');
        SEOTools::setDescription('Pelajari visi, misi, dan latar belakang Koperasi Usaha Bersama (KUBE) YPAC dalam memberdayakan siswa disabilitas agar mandiri secara ekonomi.');
        SEOTools::setCanonical(route('home.about'));
        SEOTools::opengraph()->setUrl(route('home.about'));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage(asset('images/LogoYPAC.png'));
        SEOTools::twitter()->setSite('@KubeYpac');

        return view('about');
    }

    /**
     * Display the Contact Us page.
     */
    public function contact()
    {
        // Set SEO Meta
        SEOTools::setTitle('Hubungi Kami - KUBE YPAC');
        SEOTools::setDescription('Hubungi KUBE YPAC untuk pemesanan khusus, kerjasama kemitraan, atau pertanyaan terkait produk karya anak-anak disabilitas.');
        SEOTools::setCanonical(route('home.contact'));
        SEOTools::opengraph()->setUrl(route('home.contact'));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage(asset('images/LogoYPAC.png'));
        SEOTools::twitter()->setSite('@KubeYpac');

        return view('contact');
    }

    /**
     * Process contact form submission.
     */
    public function contactSubmit(Request $request, MailtrapService $mailService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|email|max:255',
            'topic' => 'required|string',
            'message' => 'required|string',
        ]);

        $sent = $mailService->sendContactEmail(
            $request->name,
            $request->contact_info,
            $request->topic,
            $request->message
        );

        if (!$sent) {
            return redirect()->route('home.contact')
                ->withInput()
                ->with('error', 'Gagal mengirim pesan melalui email service. Silakan hubungi kami langsung via WhatsApp.');
        }

        return redirect()->route('home.contact')->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}
