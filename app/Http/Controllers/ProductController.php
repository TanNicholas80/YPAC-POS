<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\UnitProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Services\SupabaseStorageService;

class ProductController extends Controller
{
    /**
     * Display a listing of products and categories.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');
        
        if ($search) {
            $products = Product::where('product_name', 'like', '%' . $search . '%')
                ->with(['category', 'unit'])
                ->get();
        } else {
            $products = Product::with(['category', 'unit'])->get();
        }

        $categories = ProductCategory::withCount('products')->get();
        $units = UnitProduct::all();

        return view('products.index', compact('products', 'categories', 'units', 'search'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        $units = UnitProduct::all();
        return view('products.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created product in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:unit_products,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        $publicId = null;
        if ($request->hasFile('product_image')) {
            $supabase = new SupabaseStorageService();
            $imagePath = $supabase->upload($request->file('product_image'), 'products');
            if ($imagePath) {
                $prefix = "https://".config('services.supabase.project_id').".supabase.co/storage/v1/object/public/".config('services.supabase.bucket')."/";
                $publicId = str_replace($prefix, '', $imagePath);
            }
        }

        Product::create([
            'product_name' => $request->product_name,
            'product_slug' => Str::slug($request->product_name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'product_image' => $imagePath,
            'product_public_id' => $publicId,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $units = UnitProduct::all();
        return view('products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Update the specified product in database.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:unit_products,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $product->product_image;
        $publicId = $product->product_public_id;
        if ($request->hasFile('product_image')) {
            $supabase = new SupabaseStorageService();
            
            // Delete old file if exists
            if ($product->product_image) {
                if (str_starts_with($product->product_image, 'http')) {
                    $supabase->delete($product->product_image);
                } else if (File::exists(public_path($product->product_image))) {
                    File::delete(public_path($product->product_image));
                }
            }

            $imagePath = $supabase->upload($request->file('product_image'), 'products');
            if ($imagePath) {
                $prefix = "https://".config('services.supabase.project_id').".supabase.co/storage/v1/object/public/".config('services.supabase.bucket')."/";
                $publicId = str_replace($prefix, '', $imagePath);
            } else {
                $publicId = null;
            }
        }

        $product->update([
            'product_name' => $request->product_name,
            'product_slug' => Str::slug($request->product_name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'product_image' => $imagePath,
            'product_public_id' => $publicId,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from database.
     */
    public function destroy(Product $product)
    {
        // Delete image file
        if ($product->product_image) {
            if (str_starts_with($product->product_image, 'http')) {
                $supabase = new SupabaseStorageService();
                $supabase->delete($product->product_image);
            } else if (File::exists(public_path($product->product_image))) {
                File::delete(public_path($product->product_image));
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Store a newly created category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name',
        ]);

        ProductCategory::create([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
        ]);

        return redirect()->route('products.index', ['tab' => 'category'])->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function updateCategory(Request $request, ProductCategory $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name,' . $category->id,
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
        ]);

        return redirect()->route('products.index', ['tab' => 'category'])->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroyCategory(ProductCategory $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('products.index', ['tab' => 'category'])->withErrors([
                'category_delete' => 'Kategori ini tidak dapat dihapus karena masih terhubung dengan beberapa produk.'
            ]);
        }

        $category->delete();

        return redirect()->route('products.index', ['tab' => 'category'])->with('success', 'Kategori berhasil dihapus.');
    }
}
