@php
    $firstImage = $product->images->first();
    $mainImage = $firstImage ? (str_starts_with($firstImage->image_path, 'http') ? $firstImage->image_path : asset($firstImage->image_path)) : asset('images/hero_handcrafts.png');
    $isAdmin = $isAdmin ?? false;
@endphp

<div class="bg-white border border-gray-100 rounded-[2.5rem] p-6 sm:p-10 shadow-2xl relative">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <!-- Left Column: Photo Gallery -->
        <div class="md:col-span-6 space-y-4">
            <!-- Main Product Image -->
            <div class="aspect-square relative overflow-hidden rounded-[2rem] border border-gray-150 bg-gray-50/50 shadow-inner">
                <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $product->product_name }}"
                    class="object-cover w-full h-full transform hover:scale-102 transition-transform duration-500" loading="lazy">
                <span class="absolute top-4 left-4 inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-[#0073E2] text-white shadow-sm">
                    {{ $product->category->category_name ?? 'Produk' }}
                </span>
            </div>

            <!-- Gallery Thumbnails -->
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2.5">
                    @foreach($product->images as $img)
                        @php
                            $thumbnailSrc = str_starts_with($img->image_path, 'http') ? $img->image_path : asset($img->image_path);
                        @endphp
                        <button onclick="changeMainImage('{{ $thumbnailSrc }}')" 
                            class="aspect-square rounded-2xl border-2 border-gray-100 hover:border-[#0073E2] overflow-hidden bg-white shadow-sm focus:outline-none transition-all cursor-pointer">
                            <img src="{{ $thumbnailSrc }}" class="object-cover w-full h-full" loading="lazy">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column: Product Info & Tabs -->
        <div class="md:col-span-6 space-y-6">
            <!-- Header Title -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold tracking-wider uppercase {{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                        ● {{ $product->stock > 0 ? 'STOK TERSEDIA' : 'STOK HABIS' }}
                    </span>
                    <span class="text-xs text-gray-400 font-bold">Limit: {{ $product->stock }} {{ $product->unit->unit_name ?? 'pcs' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ $product->product_name }}
                </h1>
                <p class="text-2xl font-extrabold text-[#0073E2]">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>

            <!-- Info Tabs -->
            <div class="space-y-4">
                <!-- Tab Headers -->
                <div class="flex border-b border-gray-100">
                    <button onclick="switchDetailTab('desc')" id="detail-tab-btn-desc"
                        class="flex-1 pb-3 text-sm font-bold text-[#0073E2] border-b-2 border-[#0073E2] transition-colors focus:outline-none cursor-pointer">
                        Deskripsi
                    </button>
                    <button onclick="switchDetailTab('story')" id="detail-tab-btn-story"
                        class="flex-1 pb-3 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        Kisah Pembuat
                    </button>
                    <button onclick="switchDetailTab('spec')" id="detail-tab-btn-spec"
                        class="flex-1 pb-3 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        Spesifikasi
                    </button>
                </div>

                <!-- Tab Content Containers -->
                <div class="relative min-h-[120px]">
                    <!-- Deskripsi -->
                    <div id="detail-tab-content-desc" class="detail-tab-pane text-sm text-gray-500 leading-relaxed block">
                        <p>{{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>
                    </div>

                    <!-- Kisah Pembuat -->
                    <div id="detail-tab-content-story" class="detail-tab-pane text-sm text-gray-500 leading-relaxed hidden">
                        <p>{{ $product->product_story ?? 'Kisah pembuat belum ditambahkan untuk produk ini.' }}</p>
                    </div>

                    <!-- Spesifikasi -->
                    <div id="detail-tab-content-spec" class="detail-tab-pane text-sm text-gray-500 leading-relaxed hidden space-y-2">
                        @forelse($product->specifications as $spec)
                            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                                <span class="font-bold text-gray-700">{{ $spec->name }}</span>
                                <span class="font-bold text-gray-900">{{ $spec->description }}</span>
                            </div>
                        @empty
                            <p>Spesifikasi produk belum ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Action buttons (Only for guest side) -->
            @if(!$isAdmin)
                <div class="pt-6 border-t border-gray-100 space-y-4">
                    <!-- Qty selector -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-700">Jumlah:</span>
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                            <button onclick="updateProductDetailQty(-1)" class="px-4 py-2 hover:bg-gray-150 text-gray-500 font-bold transition-colors cursor-pointer select-none">-</button>
                            <input type="text" id="product-qty-input" value="1" readonly 
                                class="w-12 text-center bg-transparent border-none text-sm font-bold text-gray-800 focus:outline-none">
                            <button onclick="updateProductDetailQty(1)" class="px-4 py-2 hover:bg-gray-150 text-gray-500 font-bold transition-colors cursor-pointer select-none">+</button>
                        </div>
                    </div>
                    
                    <!-- Add to Cart -->
                    <button onclick="handleAddToCart()" 
                        class="w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-100 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 text-sm sm:text-base cursor-pointer">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        <span>Tambah ke keranjang</span>
                    </button>
                </div>
            @endif

            <!-- Feature icons -->
            <div class="grid grid-cols-4 gap-2 pt-6 border-t border-gray-105 text-center">
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-10 h-10 rounded-full bg-pink-50 text-[#e23cbf] flex items-center justify-center">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[9px] font-bold text-gray-500">Produk Inklusif</span>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-[#0073E2] flex items-center justify-center">
                        <i data-lucide="tags" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[9px] font-bold text-gray-500">Harga Terjangkau</span>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-10 h-10 rounded-full bg-orange-50 text-[#f97316] flex items-center justify-center">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[9px] font-bold text-gray-500">Hasil Pembinaan</span>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                    </div>
                    <span class="text-[9px] font-bold text-gray-500">Pengiriman Aman</span>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Live gallery swapper
    function changeMainImage(src) {
        document.getElementById('main-product-image').src = src;
    }

    // Detail page tab swapper
    function switchDetailTab(activeTab) {
        const tabs = {
            desc: { btnId: 'detail-tab-btn-desc', contentId: 'detail-tab-content-desc' },
            story: { btnId: 'detail-tab-btn-story', contentId: 'detail-tab-content-story' },
            spec: { btnId: 'detail-tab-btn-spec', contentId: 'detail-tab-content-spec' }
        };

        Object.keys(tabs).forEach(key => {
            const btn = document.getElementById(tabs[key].btnId);
            const content = document.getElementById(tabs[key].contentId);
            if (!btn || !content) return;

            if (key === activeTab) {
                btn.classList.add('text-[#0073E2]', 'border-[#0073E2]');
                btn.classList.remove('text-gray-400', 'border-transparent');
                content.classList.remove('hidden');
                content.classList.add('block');
            } else {
                btn.classList.remove('text-[#0073E2]', 'border-[#0073E2]');
                btn.classList.add('text-gray-400', 'border-transparent');
                content.classList.remove('block');
                content.classList.add('hidden');
            }
        });
    }

    @if(!$isAdmin)
        // Public page cart helper functions
        function updateProductDetailQty(change) {
            const input = document.getElementById('product-qty-input');
            if (!input) return;
            let val = parseInt(input.value) || 1;
            val += change;
            if (val < 1) val = 1;
            if (val > {{ $product->stock }}) {
                Swal.fire({
                    title: 'Stok Terbatas',
                    text: 'Stok yang tersedia tidak mencukupi.',
                    icon: 'warning',
                    confirmButtonColor: '#0073E2',
                    customClass: { popup: 'rounded-3xl' }
                });
                val = {{ $product->stock }};
            }
            input.value = val;
        }

        function handleAddToCart() {
            const qty = parseInt(document.getElementById('product-qty-input').value) || 1;
            if (window.addToCart) {
                window.addToCart({{ $product->id }}, '{{ addslashes($product->product_name) }}', {{ $product->price }}, '{{ $mainImage }}', qty);
            }
        }
    @endif
</script>
