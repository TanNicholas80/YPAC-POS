<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProductCategory;
use App\Models\UnitProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Cashier User (Budi, admin / admin123)
        User::create([
            'name' => 'Budi',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // 2. Seed Product Categories
        $categoryMakanan = ProductCategory::create([
            'category_name' => 'Makanan',
            'category_slug' => 'makanan',
        ]);
        $categoryMinuman = ProductCategory::create([
            'category_name' => 'Minuman',
            'category_slug' => 'minuman',
        ]);
        $categoryAtk = ProductCategory::create([
            'category_name' => 'ATK',
            'category_slug' => 'atk',
        ]);
        $categoryKerajinan = ProductCategory::create([
            'category_name' => 'Kerajinan',
            'category_slug' => 'kerajinan',
        ]);

        // 3. Seed Unit Products
        $unitPcs = UnitProduct::create([
            'unit_name' => 'pcs',
        ]);
        $unitPack = UnitProduct::create([
            'unit_name' => 'pack',
        ]);

        // 4. Seed Products
        Product::create([
            'category_id' => $categoryMakanan->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Snack Coklat',
            'product_slug' => 'snack-coklat',
            'description' => 'Snack coklat lezat bergizi',
            'price' => 5000,
            'stock' => 100,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categoryMakanan->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Keripik Kentang',
            'product_slug' => 'keripik-kentang',
            'description' => 'Keripik kentang renyah',
            'price' => 7000,
            'stock' => 50,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categoryMinuman->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Kopi Susu',
            'product_slug' => 'kopi-susu',
            'description' => 'Kopi susu murni',
            'price' => 10000,
            'stock' => 80,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categoryMinuman->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Teh Manis',
            'product_slug' => 'teh-manis',
            'description' => 'Teh manis dingin segar',
            'price' => 4000,
            'stock' => 120,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categoryAtk->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Buku Tulis',
            'product_slug' => 'buku-tulis',
            'description' => 'Buku tulis bergaris',
            'price' => 8000,
            'stock' => 60,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categoryAtk->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Pulpen Biru',
            'product_slug' => 'pulpen-biru',
            'description' => 'Pulpen tinta biru gel',
            'price' => 3000,
            'stock' => 150,
            'is_active' => true,
        ]);

        // Seed Sarung Bantal Hias Motif Bunga from mockup
        $sarungBantal = Product::create([
            'category_id' => $categoryKerajinan->id,
            'unit_id' => $unitPcs->id,
            'product_name' => 'Sarung Bantal Hias Motif Bunga',
            'product_slug' => 'sarung-bantal-hias-motif-bunga',
            'description' => 'Sarung bantal sofa buatan tangan dengan detail lukisan bunga. Material kain lembut dan nyaman untuk penggunaan sehari-hari. Cocok sebagai aksen dekorasi ruang tamu.',
            'product_story' => 'Karya lukis orisinal dari siswa YPAC. Setiap pembelian mendukung keberlanjutan program pelatihan kemandirian.',
            'price' => 85000,
            'stock' => 10,
            'is_active' => true,
        ]);

        // Seed images
        $sarungBantal->images()->createMany([
            ['image_path' => 'images/2G5A2489.JPG'],
            ['image_path' => 'images/2G5A2411.JPG'],
            ['image_path' => 'images/2G5A2423.JPG'],
            ['image_path' => 'images/2G5A2426.JPG'],
        ]);

        // Seed specifications
        $sarungBantal->specifications()->createMany([
            ['name' => 'Dimensi', 'description' => '40 x 40 cm'],
            ['name' => 'Material', 'description' => 'Kain Katun'],
            ['name' => 'Teknik', 'description' => 'Lukis Tangan (Hand-painted)'],
            ['name' => 'Perawatan', 'description' => 'Cuci manual dengan air dingin'],
        ]);
    }
}
