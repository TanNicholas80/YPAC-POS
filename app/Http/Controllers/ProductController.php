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
        $units = UnitProduct::withCount('products')->get();

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
            'product_story' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:unit_products,id',
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.name' => 'required|string|max:255',
            'specifications.*.description' => 'required|string|max:255',
        ]);

        $product = Product::create([
            'product_name' => $request->product_name,
            'product_slug' => Str::slug($request->product_name),
            'description' => $request->description,
            'product_story' => $request->product_story,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'is_active' => $request->has('is_active'),
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('product_images')) {
            $supabase = new SupabaseStorageService();
            foreach ($request->file('product_images') as $file) {
                $imagePath = $supabase->upload($file, 'products');
                if ($imagePath) {
                    $prefix = "https://".config('services.supabase.project_id').".supabase.co/storage/v1/object/public/".config('services.supabase.bucket')."/";
                    $publicId = str_replace($prefix, '', $imagePath);
                    $product->images()->create([
                        'image_path' => $imagePath,
                        'public_id' => $publicId,
                    ]);
                }
            }
        }

        // Handle specifications
        if ($request->has('specifications')) {
            foreach ($request->input('specifications') as $spec) {
                if (!empty($spec['name']) && !empty($spec['description'])) {
                    $product->specifications()->create([
                        'name' => $spec['name'],
                        'description' => $spec['description'],
                    ]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $product->load(['images', 'specifications']);
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
            'product_story' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:unit_products,id',
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
            'specifications' => 'nullable|array',
            'specifications.*.name' => 'required|string|max:255',
            'specifications.*.description' => 'required|string|max:255',
        ]);

        $product->update([
            'product_name' => $request->product_name,
            'product_slug' => Str::slug($request->product_name),
            'description' => $request->description,
            'product_story' => $request->product_story,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'is_active' => $request->has('is_active'),
        ]);

        // Handle deleting selected images
        if ($request->has('delete_images')) {
            $supabase = new SupabaseStorageService();
            foreach ($request->input('delete_images') as $imgId) {
                $img = $product->images()->find($imgId);
                if ($img) {
                    if (str_starts_with($img->image_path, 'http')) {
                        $supabase->delete($img->image_path);
                    } else if (File::exists(public_path($img->image_path))) {
                        File::delete(public_path($img->image_path));
                    }
                    $img->delete();
                }
            }
        }

        // Handle uploading new images
        if ($request->hasFile('product_images')) {
            $supabase = new SupabaseStorageService();
            foreach ($request->file('product_images') as $file) {
                $imagePath = $supabase->upload($file, 'products');
                if ($imagePath) {
                    $prefix = "https://".config('services.supabase.project_id').".supabase.co/storage/v1/object/public/".config('services.supabase.bucket')."/";
                    $publicId = str_replace($prefix, '', $imagePath);
                    $product->images()->create([
                        'image_path' => $imagePath,
                        'public_id' => $publicId,
                    ]);
                }
            }
        }

        // Sync specifications
        $product->specifications()->delete();
        if ($request->has('specifications')) {
            foreach ($request->input('specifications') as $spec) {
                if (!empty($spec['name']) && !empty($spec['description'])) {
                    $product->specifications()->create([
                        'name' => $spec['name'],
                        'description' => $spec['description'],
                    ]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from database.
     */
    public function destroy(Product $product)
    {
        // Delete all image files from storage
        $supabase = new SupabaseStorageService();
        foreach ($product->images as $img) {
            if (str_starts_with($img->image_path, 'http')) {
                $supabase->delete($img->image_path);
            } else if (File::exists(public_path($img->image_path))) {
                File::delete(public_path($img->image_path));
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Display the specified product preview (admin side).
     */
    public function show(Product $product)
    {
        $product->load(['category', 'unit', 'images', 'specifications']);
        return view('products.show', compact('product'));
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

    /**
     * Store a newly created unit.
     */
    public function storeUnit(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255|unique:unit_products,unit_name',
        ]);

        UnitProduct::create([
            'unit_name' => $request->unit_name,
        ]);

        return redirect()->route('products.index', ['tab' => 'unit'])->with('success', 'Satuan produk berhasil ditambahkan.');
    }

    /**
     * Update the specified unit.
     */
    public function updateUnit(Request $request, UnitProduct $unit)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255|unique:unit_products,unit_name,' . $unit->id,
        ]);

        $unit->update([
            'unit_name' => $request->unit_name,
        ]);

        return redirect()->route('products.index', ['tab' => 'unit'])->with('success', 'Satuan produk berhasil diperbarui.');
    }

    /**
     * Remove the specified unit.
     */
    public function destroyUnit(UnitProduct $unit)
    {
        if ($unit->products()->count() > 0) {
            return redirect()->route('products.index', ['tab' => 'unit'])->withErrors([
                'unit_delete' => 'Satuan ini tidak dapat dihapus karena masih terhubung dengan beberapa produk.'
            ]);
        }

        $unit->delete();

        return redirect()->route('products.index', ['tab' => 'unit'])->with('success', 'Satuan produk berhasil dihapus.');
    }
}
