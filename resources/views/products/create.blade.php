@extends('layouts.app')

@section('title', 'Tambah Produk - SIKAS YPAC')

@section('content')
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
        <h1 class="text-2xl font-bold text-gray-900 leading-tight">Tambah Produk Baru</h1>
        <p class="text-xs text-gray-500 font-medium">Lengkapi detail informasi untuk mendaftarkan produk baru ke katalog.</p>
    </div>

    <!-- Form Container -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl w-full mx-auto">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            
            <!-- Left Panel: Main Attributes (md:col-span-8) -->
            <div class="md:col-span-8 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-6">
                
                <!-- Product Name -->
                <div class="space-y-2">
                    <label for="product_name" class="text-sm font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" name="product_name" id="product_name" required value="{{ old('product_name') }}" placeholder="Contoh: Sarung Bantal Hias Motif Bunga"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
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
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Price & Stock row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Price -->
                    <div class="space-y-2">
                        <label for="price" class="text-sm font-semibold text-gray-700">Harga Jual (Rupiah)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                            <input type="number" name="price" id="price" required min="0" value="{{ old('price') }}" placeholder="Contoh: 85000"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="space-y-2">
                        <label for="stock" class="text-sm font-semibold text-gray-700">Stok Awal</label>
                        <input type="number" name="stock" id="stock" required min="0" value="{{ old('stock', 0) }}" placeholder="Contoh: 10"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="text-sm font-semibold text-gray-700">Deskripsi Produk (Opsional)</label>
                    <textarea name="description" id="description" rows="3" placeholder="Tuliskan keterangan detail produk..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm resize-none">{{ old('description') }}</textarea>
                </div>

                <!-- Product Story (Maker Story) -->
                <div class="space-y-2">
                    <label for="product_story" class="text-sm font-semibold text-gray-700">Kisah Pembuat (Opsional)</label>
                    <textarea name="product_story" id="product_story" rows="3" placeholder="Tuliskan kisah menginspirasi di balik pembuatan produk ini..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-955 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm resize-none">{{ old('product_story') }}</textarea>
                </div>

                <!-- Variants Panel -->
                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="has_variants" id="has_variants_toggle" value="1" onchange="toggleVariantsSection()"
                                class="w-5 h-5 text-[#0073E2] border-gray-300 rounded-lg focus:ring-[#0073E2] cursor-pointer">
                            <div class="space-y-0.5">
                                <span class="text-sm font-bold text-gray-800 block">Produk Memiliki Variasi</span>
                                <span class="text-[10px] text-gray-400 font-semibold block">Contoh: Warna, Pola/Motif, Ukuran dengan harga & stok khusus</span>
                            </div>
                        </label>
                        <button type="button" id="add-variant-btn" onclick="addVariantRow()" 
                            class="hidden px-3 py-1.5 bg-blue-50 text-[#0073E2] hover:bg-blue-100 font-bold rounded-xl text-xs flex items-center gap-1 cursor-pointer transition-colors">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah Variasi</span>
                        </button>
                    </div>

                    <div id="variants-container" class="hidden space-y-3">
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
                <!-- Image Upload Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-800">Foto-Foto Produk</h3>
                    
                    <!-- File input preview dropzone wrapper -->
                    <label for="product_images" id="product-image-drop-zone"
                        class="w-full aspect-[4/3] border-2 border-dashed border-gray-200 hover:border-blue-300 rounded-2xl flex flex-col items-center justify-center p-4 text-center cursor-pointer transition-all relative overflow-hidden bg-gray-50/50">
                        
                        <div id="upload-placeholder" class="space-y-2 flex flex-col items-center">
                            <i data-lucide="image-up" class="w-10 h-10 text-gray-400"></i>
                            <span class="text-xs font-bold text-gray-700 block">Pilih / Seret Gambar</span>
                            <span class="text-[10px] text-gray-400">Pilih beberapa foto</span>
                        </div>
                    </label>
                    
                    <input type="file" name="product_images[]" id="product_images" accept="image/*" multiple class="hidden" onchange="handleFileSelect(this.files); this.value='';">
                
                    <!-- Image Preview Grid -->
                    <div id="image-previews-grid" class="grid grid-cols-3 gap-2 pt-2">
                        <!-- Thumbnails with X remove icon -->
                    </div>
                </div>

                <!-- Video Upload & URL Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="video" class="w-4 h-4 text-[#0073E2]"></i>
                        <span>Video Produk (Opsional)</span>
                    </h3>
                    
                    <!-- Video URL Input -->
                    <div class="space-y-1.5">
                        <label for="video_url" class="text-xs font-semibold text-gray-600 block">Link Video (YouTube / Web URL)</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=..."
                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                    </div>

                    <div class="flex items-center gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-wider my-1">
                        <div class="flex-1 h-px bg-gray-100"></div>
                        <span>Atau Unggah File</span>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>

                    <!-- Video File Input -->
                    <div class="space-y-1.5">
                        <label for="product_video" class="text-xs font-semibold text-gray-600 block">Upload File Video (MP4 / WebM)</label>
                        <input type="file" name="product_video" id="product_video" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0073E2] hover:file:bg-blue-100 transition-all cursor-pointer">
                        <span class="text-[10px] text-gray-400 block">Maksimal 50MB</span>
                    </div>
                </div>

                <!-- Settings/Status Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-800">Pengaturan Produk</h3>
                    
                    <label class="flex items-center gap-3 cursor-pointer py-1 select-none">
                        <input type="checkbox" name="is_active" value="1" checked
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
                    <i data-lucide="save" class="w-5 h-5"></i>
                    <span>Simpan Produk</span>
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    // Variant Dynamic Inputs
    let variantIndex = 0;

    function toggleVariantsSection() {
        const toggle = document.getElementById('has_variants_toggle');
        const container = document.getElementById('variants-container');
        const addBtn = document.getElementById('add-variant-btn');

        if (toggle && toggle.checked) {
            container.classList.remove('hidden');
            addBtn.classList.remove('hidden');
            addBtn.classList.add('flex');
            if (container.children.length === 0) {
                addVariantRow('Merah - Motif Batik', '');
                addVariantRow('Biru - Motif Polkadot', '');
            }
        } else if (container && addBtn) {
            container.classList.add('hidden');
            addBtn.classList.add('hidden');
            addBtn.classList.remove('flex');
        }
    }

    function addVariantRow(name = '', price = '', stock = '') {
        const container = document.getElementById('variants-container');
        const rowId = `variant-row-${variantIndex}`;
        const basePriceInput = document.getElementById('price');
        const baseStockInput = document.getElementById('stock');

        const defaultPrice = price !== '' ? price : (basePriceInput ? basePriceInput.value : '');
        const defaultStock = stock !== '' ? stock : (baseStockInput ? baseStockInput.value : '10');

        const rowHtml = `
            <div id="${rowId}" class="bg-gray-50 p-3.5 rounded-2xl border border-gray-100 space-y-3">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-extrabold text-gray-700">Variasi #${variantIndex + 1}</span>
                    <button type="button" onclick="removeVariantRow('${rowId}')" 
                        class="p-1.5 text-gray-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition-all cursor-pointer">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                    <div class="sm:col-span-4">
                        <label class="text-[11px] font-semibold text-gray-600 block mb-1">Nama Variasi (Warna / Motif / Ukuran)</label>
                        <input type="text" name="variants[${variantIndex}][variant_name]" value="${name}" placeholder="Contoh: Merah - Motif Batik" required
                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="text-[11px] font-semibold text-gray-600 block mb-1">Harga (Rp)</label>
                        <input type="number" name="variants[${variantIndex}][price]" value="${defaultPrice}" placeholder="Harga" required min="0"
                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-[11px] font-semibold text-gray-600 block mb-1">Stok</label>
                        <input type="number" name="variants[${variantIndex}][stock]" value="${defaultStock}" placeholder="Stok" required min="0"
                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] font-semibold text-xs">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="text-[11px] font-semibold text-gray-600 block mb-1">Foto Varian (Opsional)</label>
                        <input type="file" name="variants[${variantIndex}][image]" accept="image/*"
                            class="w-full text-[10px] text-gray-500 file:mr-2 file:py-1 file:px-2 rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-[#0073E2] hover:file:bg-blue-100 transition-all cursor-pointer">
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

    function removeVariantRow(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.remove();
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
                div.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-150 bg-gray-50 group shadow-sm';
                div.innerHTML = `
                    <img src="${e.target.result}" class="object-cover w-full h-full">
                    <button type="button" onclick="removeImageFile(${index})" title="Hapus Gambar"
                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white w-5 h-5 rounded-full flex items-center justify-center shadow-md transition-all cursor-pointer">
                        <i data-lucide="x" class="w-3 h-3"></i>
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

    // Initialize with 2 default specification rows for easier use
    document.addEventListener("DOMContentLoaded", () => {
        addSpecificationRow('Dimensi', '');
        addSpecificationRow('Material', '');

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
