@php
    $firstImage = $product->images->first();
    $mainImage = $firstImage ? (str_starts_with($firstImage->image_path, 'http') ? $firstImage->image_path : asset($firstImage->image_path)) : asset('images/hero_handcrafts.png');
    $isAdmin = $isAdmin ?? false;
@endphp

<div class="bg-white border border-gray-100 rounded-[2.5rem] p-6 sm:p-10 shadow-2xl relative product-detail-card">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <!-- Left Column: Photo Gallery -->
        <div class="md:col-span-6 space-y-4 detail-gallery-column">
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
        <div class="md:col-span-6 space-y-6 detail-info-column">
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
                <p id="product-detail-price" class="text-2xl font-extrabold text-[#0073E2]">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>

            @if($product->variants->count() > 0)
                <div class="space-y-2 pt-2 border-t border-gray-100">
                    <span class="text-xs font-extrabold text-gray-700 block uppercase tracking-wider">Pilih Variasi:</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->variants as $index => $variant)
                            <button type="button" onclick="selectVariant({{ $variant->id }}, '{{ addslashes($variant->variant_name) }}', {{ $variant->price }}, {{ $variant->stock }}, '{{ $variant->image_path ? (str_starts_with($variant->image_path, 'http') ? $variant->image_path : asset($variant->image_path)) : '' }}')"
                                id="variant-btn-{{ $variant->id }}"
                                class="variant-pill-btn px-4 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer {{ $index === 0 ? 'bg-[#0073E2] text-white border-[#0073E2] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                {{ $variant->variant_name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

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
                    @if($product->video_path || $product->video_url)
                        <button onclick="switchDetailTab('video')" id="detail-tab-btn-video"
                            class="flex-1 pb-3 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-colors focus:outline-none cursor-pointer flex items-center justify-center gap-1">
                            <i data-lucide="video" class="w-4 h-4"></i>
                            <span>Video</span>
                        </button>
                    @endif
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

                    <!-- Video Produk -->
                    @if($product->video_path || $product->video_url)
                        <div id="detail-tab-content-video" class="detail-tab-pane text-sm text-gray-500 leading-relaxed hidden space-y-3">
                            @if($product->video_path)
                                @php
                                    $vSrc = str_starts_with($product->video_path, 'http') ? $product->video_path : asset($product->video_path);
                                @endphp
                                <video src="{{ $vSrc }}" controls class="w-full rounded-2xl max-h-72 bg-black object-contain shadow-sm"></video>
                            @elseif($product->video_url)
                                @php
                                    $url = $product->video_url;
                                    $embedUrl = null;
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                    }
                                @endphp
                                @if($embedUrl)
                                    <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                                        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-center justify-between gap-3">
                                        <span class="text-xs font-semibold text-gray-700">Tonton video produk di tautan eksternal:</span>
                                        <a href="{{ $url }}" target="_blank" class="px-4 py-2 bg-[#0073E2] text-white rounded-xl font-bold text-xs hover:bg-blue-600 transition-colors flex items-center gap-1.5 shrink-0">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                            <span>Buka Video</span>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
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
    let selectedVariantObj = @json($product->variants->first() ?? null);

    function selectVariant(id, name, price, stock, imageSrc) {
        selectedVariantObj = { id, name, price, stock, imageSrc };
        
        // Update price display
        const priceEl = document.getElementById('product-detail-price');
        if (priceEl) {
            priceEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        }

        // Update main image if variant has image
        if (imageSrc) {
            changeMainImage(imageSrc);
        }

        // Highlight selected pill
        document.querySelectorAll('.variant-pill-btn').forEach(btn => {
            btn.classList.remove('bg-[#0073E2]', 'text-white', 'border-[#0073E2]', 'shadow-sm');
            btn.classList.add('bg-gray-50', 'text-gray-700', 'border-gray-200');
        });

        const activeBtn = document.getElementById(`variant-btn-${id}`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-50', 'text-gray-700', 'border-gray-200');
            activeBtn.classList.add('bg-[#0073E2]', 'text-white', 'border-[#0073E2]', 'shadow-sm');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (selectedVariantObj && selectedVariantObj.image_path) {
            const imgSrc = selectedVariantObj.image_path.startsWith('http') ? selectedVariantObj.image_path : `/storage/${selectedVariantObj.image_path}`;
            changeMainImage(imgSrc);
        }
    });

    // Live gallery swapper
    function changeMainImage(src) {
        document.getElementById('main-product-image').src = src;
    }

    // Detail page tab swapper
    function switchDetailTab(activeTab) {
        const tabs = {
            desc: { btnId: 'detail-tab-btn-desc', contentId: 'detail-tab-content-desc' },
            story: { btnId: 'detail-tab-btn-story', contentId: 'detail-tab-content-story' },
            spec: { btnId: 'detail-tab-btn-spec', contentId: 'detail-tab-content-spec' },
            video: { btnId: 'detail-tab-btn-video', contentId: 'detail-tab-content-video' }
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
            const maxStock = selectedVariantObj ? selectedVariantObj.stock : {{ $product->stock }};
            if (val > maxStock) {
                Swal.fire({
                    title: 'Stok Terbatas',
                    text: 'Stok yang tersedia tidak mencukupi.',
                    icon: 'warning',
                    confirmButtonColor: '#0073E2',
                    customClass: { popup: 'rounded-3xl' }
                });
                val = maxStock;
            }
            input.value = val;
        }

        function handleAddToCart() {
            const qty = parseInt(document.getElementById('product-qty-input').value) || 1;
            let productName = '{{ addslashes($product->product_name) }}';
            let price = {{ $product->price }};
            let variantId = null;
            let variantName = null;

            if (selectedVariantObj) {
                productName += ' (' + selectedVariantObj.name + ')';
                price = selectedVariantObj.price;
                variantId = selectedVariantObj.id;
                variantName = selectedVariantObj.name;
            }

            if (window.addToCart) {
                window.addToCart({{ $product->id }}, productName, price, '{{ $mainImage }}', qty, variantId, variantName);
            }
        }
    @endif
</script>
