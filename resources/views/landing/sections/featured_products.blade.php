<!-- Produk Unggulan Section -->
<section class="py-20 lg:py-28 bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12 featured-products-header">
            <div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mt-1">Produk Unggulan
                </h2>
            </div>
            <a href="{{ route('home.products') }}"
                class="inline-flex items-center gap-1 text-sm font-bold text-[#0073E2] hover:text-blue-700 transition-colors">
                <span>Lihat semua produk</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- 3 Product Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 featured-products-grid">
            @foreach ($topProducts as $product)
                @php
                    $firstImage = $product->images->first();
                    $imageSrc = $firstImage ? (str_starts_with($firstImage->image_path, 'http') ? $firstImage->image_path : asset($firstImage->image_path)) : asset('images/hero_handcrafts.png');
                @endphp

                <div
                    class="group bg-[#F8FAFC] border border-gray-100 rounded-3xl overflow-hidden hover:shadow-xl hover:shadow-gray-200/50 hover:bg-white hover:border-gray-200 transition-[box-shadow,border-color,background-color] duration-300 flex flex-col justify-between h-full featured-product-card-item">
                    <div>
                        <!-- Aspect ratio 4:3 Product Image -->
                        <div class="aspect-4/3 relative overflow-hidden bg-gray-100 border-b border-gray-100">
                            <img src="{{ $imageSrc }}" alt="{{ $product->product_name }}"
                                class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            <span
                                class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#0073E2] text-white shadow-sm">
                                {{ $product->category->category_name ?? 'Produk' }}
                            </span>
                        </div>

                        <div class="p-6 space-y-2">
                            <h3
                                class="font-extrabold text-gray-900 text-lg leading-snug group-hover:text-[#0073E2] transition-colors line-clamp-1">
                                {{ $product->product_name }}
                            </h3>
                            <p class="text-xs text-gray-500 font-medium line-clamp-2">
                                {{ $product->description ?? 'Produk orisinal karya KUBE YPAC.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 pt-0 space-y-4">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs font-bold text-gray-400">Harga</span>
                            <span class="text-xl font-extrabold text-gray-900">
                                {{ $product->price_range }}
                            </span>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex gap-2.5">
                            <!-- Button Detail -->
                            <a href="{{ route('home.product.detail', $product->product_slug) }}" 
                                class="flex-1 py-3 bg-gray-50 hover:bg-gray-150 border border-gray-200 text-gray-700 font-bold rounded-2xl transition-all duration-200 flex items-center justify-center gap-2 text-sm text-center">
                                <i data-lucide="eye" class="w-4 h-4 text-gray-500"></i>
                                <span>Detail</span>
                            </a>
                            <!-- Button Tambah -->
                            <button
                                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->product_name) }}', {{ $product->price }}, '{{ $imageSrc }}')"
                                class="flex-1 py-3 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-md shadow-blue-100 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm cursor-pointer">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                <span>+ Keranjang</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>