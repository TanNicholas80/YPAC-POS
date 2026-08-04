<!-- Catalog Page Hero Banner Section -->
<section class="relative py-16 sm:py-24 bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('{{ asset('images/bg_katalog_produk.png') }}');">
    <!-- Overlay Hitam Transparan -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Page Title Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4 catalog-header">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                Katalog Produk
            </h1>
            <p class="text-base text-gray-100 leading-relaxed">
                Temukan berbagai produk berkualitas karya pemuda disabilitas. Setiap pembelian Anda secara langsung mendukung kemandirian dan kreativitas mereka dalam membangun masa depan yang lebih baik.
            </p>
        </div>
    </div>
</section>

<!-- Catalog Page Main Controls & Grid Section -->
<section class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search and Filter Controls -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12 border-b border-gray-105 pb-8 catalog-controls">
            <!-- Search Box -->
            <div class="relative w-full md:max-w-md">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </span>
                <input type="text" id="catalog-search" oninput="filterCatalog()" placeholder="Cari Produk..."
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-850">
            </div>

            <!-- Category Pills (Dynamic from database) -->
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-none">
                <!-- Semua Pill -->
                <button onclick="filterCategory('all', this)" id="category-all-btn"
                    class="category-filter-btn px-5 py-2.5 rounded-full text-xs font-bold transition-all border cursor-pointer bg-[#0073E2] text-white border-transparent shadow-md shadow-blue-100">
                    Semua
                </button>
                
                @foreach ($categories as $category)
                    <button onclick="filterCategory('{{ $category->category_slug }}', this)"
                        class="category-filter-btn px-5 py-2.5 rounded-full text-xs font-bold transition-all border cursor-pointer bg-white text-gray-600 border-gray-250 hover:bg-gray-50 hover:text-gray-900">
                        {{ $category->category_name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Product Cards Grid -->
        <div id="catalog-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($allProducts as $product)
                @php
                    $firstImage = $product->images->first();
                    $imageSrc = $firstImage ? (str_starts_with($firstImage->image_path, 'http') ? $firstImage->image_path : asset($firstImage->image_path)) : asset('images/hero_handcrafts.png');
                @endphp

                <!-- Product Card Element -->
                <div data-name="{{ strtolower($product->product_name) }}" data-category="{{ $product->category->category_slug ?? '' }}"
                    class="product-card-item group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-xl hover:shadow-gray-200/40 hover:border-gray-250 transition-[box-shadow,border-color,background-color] duration-300 flex flex-col justify-between h-full">
                    <div>
                        <!-- Product Image -->
                        <div class="aspect-4/3 relative overflow-hidden bg-gray-50 border-b border-gray-100">
                            <img src="{{ $imageSrc }}" alt="{{ $product->product_name }}"
                                class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            <span
                                class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-white text-[#0073E2] shadow-sm border border-gray-100">
                                {{ $product->category->category_name ?? 'Produk' }}
                            </span>
                        </div>

                        <div class="p-6 space-y-2">
                            <h3
                                class="font-extrabold text-gray-900 text-lg leading-snug group-hover:text-[#0073E2] transition-colors line-clamp-1">
                                {{ $product->product_name }}
                            </h3>
                            <p class="text-xs text-gray-500 font-medium line-clamp-2">
                                {{ strip_tags($product->description) ?: 'Karya berkualitas hasil kerajinan dan kreasi siswa KUBE YPAC.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 pt-0 space-y-4">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs font-bold text-gray-400">Harga ({{ $product->unit->unit_name ?? 'pcs' }})</span>
                            <span class="text-xl font-extrabold text-[#0073E2]">
                                {{ $product->price_range }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div>
                            <!-- Button Detail Only -->
                            <a href="{{ route('home.product.detail', $product->product_slug) }}" 
                                class="w-full py-3 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-md shadow-blue-100 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm text-center">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                <span>Lihat Detail Produk</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State for Search/Filter Results -->
        <div id="catalog-empty-results" class="hidden flex flex-col items-center justify-center py-20 text-center space-y-4">
            <div class="w-16 h-16 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center">
                <i data-lucide="search-code" class="w-8 h-8"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Produk Tidak Ditemukan</h3>
                <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci pencarian atau filter kategori lainnya.</p>
            </div>
            <button onclick="resetFilters()"
                class="px-5 py-2.5 bg-[#0073E2] text-white font-bold text-xs rounded-xl shadow-md cursor-pointer">
                Reset Pencarian
            </button>
        </div>

    </div>
</section>
