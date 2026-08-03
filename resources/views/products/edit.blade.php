@extends('layouts.app')

@section('title', 'Edit Produk - SIKAS YPAC')

@section('content')
<style>
    .ql-toolbar.ql-snow {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        border-color: #f3f4f6;
        background-color: #f9fafb;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
        border-color: #f3f4f6;
        background-color: #ffffff;
        font-family: inherit;
        min-height: 120px;
    }
    .ql-editor {
        min-height: 120px;
        font-size: 0.875rem;
    }
</style>

<div class="flex-1 flex flex-col p-6 overflow-y-auto">
    
    <!-- Back Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-[#0073E2] hover:text-blue-600 transition-colors font-bold text-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            <span>Kembali ke Manajemen Produk</span>
        </a>
    </div>

    <!-- Title Header -->
    <div class="max-w-4xl w-full mx-auto mb-6">
        <h1 class="text-2xl font-bold text-gray-900 leading-tight">Edit Produk</h1>
        <p class="text-xs text-gray-550 font-medium">Ubah rincian informasi dan perbarui stock ketersediaan produk.</p>
    </div>

    <!-- Form Container -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl w-full mx-auto">
        @csrf
        @method('PUT')
        <div id="deleted-images-container"></div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            
            <!-- Left Panel: Main Attributes (md:col-span-8) -->
            <div class="md:col-span-8 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-6">
                
                <!-- Product Name -->
                <div class="space-y-2">
                    <label for="product_name" class="text-sm font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" name="product_name" id="product_name" required value="{{ old('product_name', $product->product_name) }}" placeholder="Contoh: Sarung Bantal Hias Motif Bunga"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                </div>

                <!-- Category & Unit row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category_id" class="text-sm font-semibold text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unit -->
                    <div class="space-y-2">
                        <label for="unit_id" class="text-sm font-semibold text-gray-700">Satuan (Unit)</label>
                        <select name="unit_id" id="unit_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                            <option value="">-- Pilih Satuan --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Price & Stock row -->
                <div class="space-y-2">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Price -->
                        <div class="space-y-2">
                            <label for="price" class="text-sm font-semibold text-gray-700">Harga Jual (Rupiah)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                                <input type="number" name="price" id="price" {{ $product->variants->count() > 0 ? '' : 'required' }} min="0" value="{{ old('price', (int)$product->price) }}" placeholder="Contoh: 5000"
                                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="space-y-2">
                            <label for="stock" class="text-sm font-semibold text-gray-700">Jumlah Stok</label>
                            <input type="number" name="stock" id="stock" {{ $product->variants->count() > 0 ? '' : 'required' }} min="0" value="{{ old('stock', $product->stock) }}" placeholder="Contoh: 50"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                        </div>
                    </div>
                    <p id="variant-price-hint" class="{{ $product->variants->count() > 0 ? '' : 'hidden' }} text-xs text-[#0073E2] font-semibold bg-blue-50/60 p-2.5 rounded-xl border border-blue-100">
                        💡 <strong>Catatan Variasi:</strong> Karena produk memiliki variasi, Rentang Harga & Total Stok dihitung otomatis dari harga & stok tiap varian. Field di atas opsional.
                    </p>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Deskripsi Produk (Opsional)</label>
                    <input type="hidden" name="description" id="description" value="{{ old('description', $product->description) }}">
                    <div id="quill-description" class="rounded-2xl">{!! old('description', $product->description) !!}</div>
                </div>

                <!-- Product Story (Maker Story) -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Kisah Pembuat (Opsional)</label>
                    <input type="hidden" name="product_story" id="product_story" value="{{ old('product_story', $product->product_story) }}">
                    <div id="quill-product_story" class="rounded-2xl">{!! old('product_story', $product->product_story) !!}</div>
                </div>

                <!-- Variants Panel -->
                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="has_variants" id="has_variants_toggle" value="1" {{ $product->variants->count() > 0 ? 'checked' : '' }} onchange="toggleVariantsSection()"
                                class="w-5 h-5 text-[#0073E2] border-gray-300 rounded-lg focus:ring-[#0073E2] cursor-pointer">
                            <div class="space-y-0.5">
                                <span class="text-sm font-bold text-gray-800 block">Produk Memiliki Variasi</span>
                                <span class="text-[10px] text-gray-400 font-semibold block">Contoh: Warna, Pola/Motif, Ukuran dengan harga & stok khusus</span>
                            </div>
                        </label>
                        <button type="button" id="add-variant-btn" onclick="addVariantRow()" 
                            class="{{ $product->variants->count() > 0 ? 'flex' : 'hidden' }} px-3 py-1.5 bg-blue-50 text-[#0073E2] hover:bg-blue-100 font-bold rounded-xl text-xs items-center gap-1 cursor-pointer transition-colors">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah Variasi</span>
                        </button>
                    </div>

                    <div id="variants-container" class="{{ $product->variants->count() > 0 ? '' : 'hidden' }} space-y-3">
                        <!-- Dynamic variant rows append here -->
                    </div>
                </div>

                <!-- Specifications Panel -->
                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-gray-700">Spesifikasi Produk</label>
                        <button type="button" onclick="addSpecificationRow()" 
                            class="px-3 py-1.5 bg-blue-50 text-[#0073E2] hover:bg-blue-100 font-bold rounded-xl text-xs flex items-center gap-1 cursor-pointer transition-colors">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah Baris</span>
                        </button>
                    </div>

                    <div id="specifications-container" class="space-y-3">
                        <!-- Dynamic rows append here -->
                    </div>
                </div>

            </div>

            <!-- Right Panel: Image & Status (md:col-span-4) -->
            <div class="md:col-span-4 space-y-6">
                
                <!-- Existing Images Card -->
                @if($product->images->count() > 0)
                    <div id="existing-images-card" class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-800">Foto Saat Ini</h3>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-xl">{{ $product->images->count() }} Foto</span>
                        </div>
                        
                        <div id="existing-images-grid" class="grid grid-cols-3 gap-2.5">
                            @foreach($product->images as $img)
                                @php
                                    $imgSrc = str_starts_with($img->image_path, 'http') ? $img->image_path : asset($img->image_path);
                                @endphp
                                <div id="existing-img-card-{{ $img->id }}" class="relative aspect-square rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 group shadow-xs transition-all">
                                    <img src="{{ $imgSrc }}" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105">
                                    
                                    <button type="button" onclick="deleteExistingImage({{ $img->id }})" title="Hapus Foto Ini"
                                        class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-500/90 hover:bg-red-600 active:scale-90 text-white rounded-xl flex items-center justify-center shadow-md transition-all cursor-pointer">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Image Upload Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-800">Tambah Foto Produk Baru</h3>
                    
                    <!-- File input preview dropzone wrapper -->
                    <label for="product_images" id="product-image-drop-zone"
                        class="w-full aspect-[4/3] border-2 border-dashed border-gray-200 hover:border-[#0073E2] rounded-2xl flex flex-col items-center justify-center p-4 text-center cursor-pointer transition-all relative overflow-hidden bg-gray-50/50 group">
                        
                        <div id="upload-placeholder" class="space-y-2 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-[#0073E2] flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-lucide="image-plus" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-[#0073E2] transition-colors block">Pilih / Seret Gambar Baru</span>
                            <span class="text-[10px] text-gray-400">PNG, JPG, WEBP (Bisa Pilih Banyak)</span>
                        </div>
                    </label>
                    
                    <input type="file" name="product_images[]" id="product_images" accept="image/*" multiple class="hidden" onchange="handleFileSelect(this.files)">
                
                    <!-- Image Preview Grid -->
                    <div id="image-previews-grid" class="grid grid-cols-3 gap-2.5 pt-1">
                        <!-- Thumbnails with trash icon -->
                    </div>
                </div>

                <!-- Video Upload & URL Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="video" class="w-4 h-4 text-[#0073E2]"></i>
                        <span>Video Produk (Opsional)</span>
                    </h3>
                    
                    @if($product->video_path || $product->video_url)
                        <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100 space-y-2">
                            <span class="text-xs font-bold text-gray-700 block">Video Saat Ini:</span>
                            @if($product->video_path)
                                @php
                                    $videoSrc = str_starts_with($product->video_path, 'http') ? $product->video_path : asset($product->video_path);
                                @endphp
                                <video src="{{ $videoSrc }}" controls class="w-full rounded-xl max-h-48 object-cover bg-black"></video>
                                <label class="flex items-center gap-2 mt-2 text-xs font-semibold text-red-600 cursor-pointer">
                                    <input type="checkbox" name="delete_video" value="1" class="w-4 h-4 accent-red-500 rounded">
                                    <span>Hapus File Video saat disimpan</span>
                                </label>
                            @elseif($product->video_url)
                                <a href="{{ $product->video_url }}" target="_blank" class="text-xs text-[#0073E2] hover:underline flex items-center gap-1 font-semibold break-all">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5 flex-shrink-0"></i>
                                    <span>{{ $product->video_url }}</span>
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Video URL Input -->
                    <div class="space-y-1.5">
                        <label for="video_url" class="text-xs font-semibold text-gray-600 block">Link Video (YouTube / Web URL)</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $product->video_url) }}" placeholder="https://www.youtube.com/watch?v=..."
                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                    </div>

                    <div class="flex items-center gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-wider my-1">
                        <div class="flex-1 h-px bg-gray-100"></div>
                        <span>Atau Unggah File Baru</span>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>

                    <!-- Video File Input -->
                    <div class="space-y-1.5">
                        <label for="product_video" class="text-xs font-semibold text-gray-600 block">Upload File Video Baru (MP4 / WebM)</label>
                        <input type="file" name="product_video" id="product_video" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0073E2] hover:file:bg-blue-100 transition-all cursor-pointer">
                        <span class="text-[10px] text-gray-400 block">Maksimal 50MB</span>
                    </div>
                </div>

                <!-- Settings/Status Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-800">Pengaturan Produk</h3>
                    
                    <label class="flex items-center gap-3 cursor-pointer py-1 select-none">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                            class="w-5 h-5 text-[#0073E2] border-gray-300 rounded-lg focus:ring-[#0073E2] cursor-pointer">
                        <div class="space-y-0.5">
                            <span class="text-sm font-bold text-gray-800 block">Aktifkan di Katalog</span>
                            <span class="text-[10px] text-gray-400 font-semibold block">Tampilkan produk di mesin kasir sales</span>
                        </div>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 text-base cursor-pointer">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    <span>Perbarui Produk</span>
                </button>
            </div>

        </div>
    </form>
<script>
    // Variant Dynamic Inputs
    let variantIndex = 0;

    function toggleVariantsSection() {
        const toggle = document.getElementById('has_variants_toggle');
        const container = document.getElementById('variants-container');
        const addBtn = document.getElementById('add-variant-btn');
        const priceInput = document.getElementById('price');
        const stockInput = document.getElementById('stock');
        const variantHint = document.getElementById('variant-price-hint');

        if (toggle && toggle.checked) {
            container.classList.remove('hidden');
            addBtn.classList.remove('hidden');
            addBtn.classList.add('flex');
            if (priceInput) priceInput.removeAttribute('required');
            if (stockInput) stockInput.removeAttribute('required');
            if (variantHint) variantHint.classList.remove('hidden');

            if (container.children.length === 0) {
                addVariantRow('Merah - Motif Batik', '');
                addVariantRow('Biru - Motif Polkadot', '');
            }
        } else if (container && addBtn) {
            container.classList.add('hidden');
            addBtn.classList.add('hidden');
            addBtn.classList.remove('flex');
            if (priceInput) priceInput.setAttribute('required', 'required');
            if (stockInput) stockInput.setAttribute('required', 'required');
            if (variantHint) variantHint.classList.add('hidden');
        }
    }

    function addVariantRow(name = '', price = '', stock = '', id = '', imagePath = '') {
        const container = document.getElementById('variants-container');
        const currentIndex = variantIndex;
        const rowId = `variant-row-${currentIndex}`;
        const basePriceInput = document.getElementById('price');
        const baseStockInput = document.getElementById('stock');

        const defaultPrice = price !== '' ? price : (basePriceInput ? basePriceInput.value : '');
        const defaultStock = stock !== '' ? stock : (baseStockInput ? baseStockInput.value : '10');

        const rowHtml = `
            <div id="${rowId}" class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-xs space-y-4 relative transition-all hover:border-gray-300">
                <input type="hidden" name="variants[${currentIndex}][id]" value="${id}">
                <input type="hidden" id="remove-img-input-${currentIndex}" name="variants[${currentIndex}][remove_image]" value="0">

                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#0073E2] font-extrabold text-xs flex items-center justify-center">${currentIndex + 1}</span>
                        <h4 class="text-xs font-bold text-gray-800">Variasi #${currentIndex + 1}</h4>
                    </div>
                    <button type="button" onclick="removeVariantRow('${rowId}', '${id}')" 
                        class="px-2.5 py-1 text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors cursor-pointer flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Variasi</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-8 space-y-3">
                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1">Nama Variasi <span class="text-red-500">*</span></label>
                            <input type="text" name="variants[${currentIndex}][variant_name]" value="${name}" placeholder="Contoh: Merah - Motif Batik / Ukuran XL" required
                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white font-semibold text-xs transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">Harga Variasi (Rp) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                    <input type="number" name="variants[${currentIndex}][price]" value="${defaultPrice}" placeholder="700000" required min="0"
                                        class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white font-semibold text-xs transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">Stok Variasi <span class="text-red-500">*</span></label>
                                <input type="number" name="variants[${currentIndex}][stock]" value="${defaultStock}" placeholder="10" required min="0"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white font-semibold text-xs transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-4 space-y-1">
                        <label class="text-xs font-bold text-gray-700 block">Foto Varian (Opsional)</label>
                        <input type="file" id="variant-file-input-${currentIndex}" name="variants[${currentIndex}][image]" accept="image/*" class="hidden" onchange="handleVariantImageChange(this, ${currentIndex})">
                        
                        <div id="variant-dropzone-${currentIndex}" 
                            onclick="document.getElementById('variant-file-input-${currentIndex}').click()"
                            ondragenter="handleVariantDrag(event, ${currentIndex}, true)"
                            ondragover="handleVariantDrag(event, ${currentIndex}, true)"
                            ondragleave="handleVariantDrag(event, ${currentIndex}, false)"
                            ondrop="handleVariantDrop(event, ${currentIndex})"
                            class="border-2 border-dashed border-gray-200 hover:border-[#0073E2] bg-gray-50/70 hover:bg-blue-50/20 rounded-xl p-3 text-center cursor-pointer transition-all min-h-[110px] flex flex-col items-center justify-center group relative overflow-hidden">
                            
                            <div id="variant-upload-placeholder-${currentIndex}" class="${imagePath ? 'hidden' : 'flex'} flex-col items-center gap-1">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0073E2] flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i data-lucide="image-plus" class="w-4 h-4"></i>
                                </div>
                                <span class="text-[11px] font-bold text-gray-700 group-hover:text-[#0073E2] transition-colors">Pilih / Drag Foto</span>
                                <span class="text-[9px] font-medium text-gray-400">PNG, JPG, WEBP</span>
                            </div>

                            <div id="variant-preview-container-${currentIndex}" class="${imagePath ? 'flex' : 'hidden'} flex-col items-center w-full h-full relative">
                                <img id="variant-img-preview-${currentIndex}" src="${imagePath || ''}" class="w-20 h-20 object-cover rounded-xl border border-gray-200 shadow-xs">
                                <div class="flex items-center gap-1.5 mt-2">
                                    <span class="text-[10px] font-bold text-[#0073E2] hover:underline">Ganti Foto</span>
                                    <span class="text-gray-300 text-xs">•</span>
                                    <button type="button" onclick="clearVariantImage(event, ${currentIndex})" class="text-[10px] font-bold text-red-500 hover:text-red-700 hover:underline cursor-pointer">
                                        Hapus Foto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', rowHtml);
        variantIndex++;

        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function removeVariantRow(rowId, id = '') {
        const row = document.getElementById(rowId);
        if (row) {
            if (id) {
                const container = document.getElementById('variants-container');
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'delete_variants[]';
                hiddenInput.value = id;
                container.appendChild(hiddenInput);
            }
            row.remove();
        }
    }

    function handleVariantImageChange(input, idx) {
        const file = input.files && input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgPreview = document.getElementById(`variant-img-preview-${idx}`);
                const placeholder = document.getElementById(`variant-upload-placeholder-${idx}`);
                const container = document.getElementById(`variant-preview-container-${idx}`);
                const removeInput = document.getElementById(`remove-img-input-${idx}`);

                if (imgPreview) imgPreview.src = e.target.result;
                if (placeholder) placeholder.classList.add('hidden');
                if (container) {
                    container.classList.remove('hidden');
                    container.classList.add('flex');
                }
                if (removeInput) removeInput.value = "0";
            };
            reader.readAsDataURL(file);
        }
    }

    function clearVariantImage(event, idx) {
        event.stopPropagation();
        event.preventDefault();

        const fileInput = document.getElementById(`variant-file-input-${idx}`);
        const imgPreview = document.getElementById(`variant-img-preview-${idx}`);
        const placeholder = document.getElementById(`variant-upload-placeholder-${idx}`);
        const container = document.getElementById(`variant-preview-container-${idx}`);
        const removeInput = document.getElementById(`remove-img-input-${idx}`);

        if (fileInput) fileInput.value = '';
        if (imgPreview) imgPreview.src = '';
        if (placeholder) {
            placeholder.classList.remove('hidden');
            placeholder.classList.add('flex');
        }
        if (container) {
            container.classList.add('hidden');
            container.classList.remove('flex');
        }
        if (removeInput) removeInput.value = "1";
    }

    function handleVariantDrag(e, idx, isDragging) {
        e.preventDefault();
        e.stopPropagation();
        const dropzone = document.getElementById(`variant-dropzone-${idx}`);
        if (dropzone) {
            if (isDragging) {
                dropzone.classList.add('border-[#0073E2]', 'bg-blue-50/40');
            } else {
                dropzone.classList.remove('border-[#0073E2]', 'bg-blue-50/40');
            }
        }
    }

    function handleVariantDrop(e, idx) {
        e.preventDefault();
        e.stopPropagation();
        const dropzone = document.getElementById(`variant-dropzone-${idx}`);
        if (dropzone) {
            dropzone.classList.remove('border-[#0073E2]', 'bg-blue-50/40');
        }

        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length > 0) {
            const fileInput = document.getElementById(`variant-file-input-${idx}`);
            if (fileInput) {
                fileInput.files = dt.files;
                handleVariantImageChange(fileInput, idx);
            }
        }
    }

    // Accumulative Image Upload with Remove Icon
    let selectedImageFiles = [];

    function handleFileSelect(newFiles) {
        if (!newFiles || newFiles.length === 0) return;
        
        Array.from(newFiles).forEach(file => {
            const isDuplicate = selectedImageFiles.some(f => f.name === file.name && f.size === file.size);
            if (!isDuplicate) {
                selectedImageFiles.push(file);
            }
        });

        syncAndRenderImages();
    }

    function removeImageFile(index) {
        selectedImageFiles.splice(index, 1);
        syncAndRenderImages();
    }

    function deleteExistingImage(imgId) {
        const card = document.getElementById(`existing-img-card-${imgId}`);
        if (!card) return;

        // Safely append hidden input delete_images[] into deleted-images-container
        let deletedContainer = document.getElementById('deleted-images-container');
        if (!deletedContainer) {
            deletedContainer = document.createElement('div');
            deletedContainer.id = 'deleted-images-container';
            const form = document.querySelector('form');
            if (form) form.appendChild(deletedContainer);
        }

        // Avoid adding duplicate hidden inputs for the same imgId
        const existingInput = document.querySelector(`input[name="delete_images[]"][value="${imgId}"]`);
        if (!existingInput) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'delete_images[]';
            hiddenInput.value = imgId;
            deletedContainer.appendChild(hiddenInput);
        }

        // Animate and remove card
        card.style.transition = 'all 0.3s ease';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.8)';
        setTimeout(() => {
            card.remove();
            const grid = document.getElementById('existing-images-grid');
            if (grid && grid.children.length === 0) {
                const existingCard = document.getElementById('existing-images-card');
                if (existingCard) existingCard.classList.add('hidden');
            }
        }, 300);
    }

    // Main Product Image Drag & Drop
    document.addEventListener('DOMContentLoaded', () => {
        const mainDropZone = document.getElementById('product-image-drop-zone');
        if (mainDropZone) {
            mainDropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.stopPropagation();
                mainDropZone.classList.add('border-[#0073E2]', 'bg-blue-50/40');
            });
            mainDropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                e.stopPropagation();
                mainDropZone.classList.remove('border-[#0073E2]', 'bg-blue-50/40');
            });
            mainDropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                mainDropZone.classList.remove('border-[#0073E2]', 'bg-blue-50/40');
                if (e.dataTransfer && e.dataTransfer.files) {
                    handleFileSelect(e.dataTransfer.files);
                }
            });
        }
    });

    function syncAndRenderImages() {
        const fileInput = document.getElementById('product_images');
        const grid = document.getElementById('image-previews-grid');
        grid.innerHTML = '';

        const dt = new DataTransfer();
        selectedImageFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;

        selectedImageFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 group shadow-xs transition-all';
                div.innerHTML = `
                    <img src="${e.target.result}" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105">
                    <button type="button" onclick="removeImageFile(${index})" title="Hapus Foto Ini"
                        class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-500/90 hover:bg-red-600 active:scale-90 text-white rounded-xl flex items-center justify-center shadow-md transition-all cursor-pointer">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                `;
                grid.appendChild(div);
                if (window.lucide) {
                    lucide.createIcons();
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // Specifications Dynamic Inputs
    let specIndex = 0;
    function addSpecificationRow(name = '', description = '') {
        const container = document.getElementById('specifications-container');
        const rowId = `spec-row-${specIndex}`;
        
        const rowHtml = `
            <div id="${rowId}" class="flex items-center gap-2.5 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                <input type="text" name="specifications[${specIndex}][name]" value="${name}" placeholder="Nama (Cth: Dimensi)" required
                    class="flex-1 px-3.5 py-2.5 bg-white border border-gray-150 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                <input type="text" name="specifications[${specIndex}][description]" value="${description}" placeholder="Nilai (Cth: 40 x 40 cm)" required
                    class="flex-1 px-3.5 py-2.5 bg-white border border-gray-150 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                <button type="button" onclick="removeSpecificationRow('${rowId}')" 
                    class="p-2.5 text-gray-400 hover:text-red-500 rounded-xl hover:bg-red-50 transition-all cursor-pointer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', rowHtml);
        specIndex++;

        // Refresh icons
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function removeSpecificationRow(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.remove();
        }
    }

    // Load existing product specifications, variants & init Quill Editors
    let quillDesc, quillStory;

    document.addEventListener("DOMContentLoaded", () => {
        if (window.Quill) {
            quillDesc = new Quill('#quill-description', {
                theme: 'snow',
                placeholder: 'Tuliskan keterangan detail produk...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });

            quillStory = new Quill('#quill-product_story', {
                theme: 'snow',
                placeholder: 'Tuliskan kisah menginspirasi di balik pembuatan produk ini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });

            const productForm = document.querySelector('form');
            if (productForm) {
                productForm.addEventListener('submit', () => {
                    if (quillDesc) {
                        const html = quillDesc.root.innerHTML;
                        document.getElementById('description').value = html === '<p><br></p>' ? '' : html;
                    }
                    if (quillStory) {
                        const html = quillStory.root.innerHTML;
                        document.getElementById('product_story').value = html === '<p><br></p>' ? '' : html;
                    }
                });
            }
        }
        @foreach($product->variants as $variant)
            @php
                $vImgSrc = $variant->image_path ? (str_starts_with($variant->image_path, 'http') ? $variant->image_path : asset($variant->image_path)) : '';
            @endphp
            addVariantRow('{{ addslashes($variant->variant_name) }}', '{{ (int)$variant->price }}', '{{ $variant->stock }}', '{{ $variant->id }}', '{{ $vImgSrc }}');
        @endforeach

        @forelse($product->specifications as $spec)
            addSpecificationRow('{{ addslashes($spec->name) }}', '{{ addslashes($spec->description) }}');
        @empty
            addSpecificationRow('Dimensi', '');
            addSpecificationRow('Material', '');
        @endforelse

        // Drag and Drop integration
        const dropZone = document.getElementById('product-image-drop-zone');
        if (dropZone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('border-[#0073E2]', 'bg-blue-50/20');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('border-[#0073E2]', 'bg-blue-50/20');
                }, false);
            });

            dropZone.addEventListener('drop', e => {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files && files.length > 0) {
                    handleFileSelect(files);
                }
            }, false);
        }
    });
</script>
@endsection
