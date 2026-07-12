@extends('layouts.app')

@section('title', 'Tambah Produk - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 overflow-y-auto bg-[#F5F8FC]">
    
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
                    <input type="text" name="product_name" id="product_name" required value="{{ old('product_name') }}" placeholder="Contoh: Snack Coklat YPAC"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                </div>

                <!-- Category & Unit row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category_id" class="text-sm font-semibold text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
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
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
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
                            <input type="number" name="price" id="price" required min="0" value="{{ old('price') }}" placeholder="Contoh: 5000"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="space-y-2">
                        <label for="stock" class="text-sm font-semibold text-gray-700">Stok Awal</label>
                        <input type="number" name="stock" id="stock" required min="0" value="{{ old('stock', 0) }}" placeholder="Contoh: 50"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="text-sm font-semibold text-gray-700">Deskripsi Produk (Opsional)</label>
                    <textarea name="description" id="description" rows="4" placeholder="Tuliskan keterangan detail produk..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm resize-none">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Right Panel: Image & Status (md:col-span-4) -->
            <div class="md:col-span-4 space-y-6">
                <!-- Image Upload Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4 flex flex-col items-center">
                    <h3 class="text-sm font-bold text-gray-800 w-full text-left">Foto Produk</h3>
                    
                    <!-- File input preview dropzone wrapper -->
                    <label for="product_image" id="product-image-drop-zone"
                        class="w-full aspect-square border-2 border-dashed border-gray-200 hover:border-blue-300 rounded-2xl flex flex-col items-center justify-center p-4 text-center cursor-pointer transition-all relative overflow-hidden bg-gray-50/50">
                        
                        <div id="upload-placeholder" class="space-y-2 flex flex-col items-center">
                            <i data-lucide="image-up" class="w-10 h-10 text-gray-400"></i>
                            <span class="text-xs font-bold text-gray-700 block">Pilih / Seret Gambar</span>
                            <span class="text-[10px] text-gray-400">PNG, JPG, JPEG (Maks 2MB)</span>
                        </div>

                        <!-- Image Preview element -->
                        <img id="image-preview" src="#" alt="Preview Foto" class="absolute inset-0 w-full h-full object-cover hidden bg-white">
                    </label>
                    
                    <input type="file" name="product_image" id="product_image" accept="image/*" class="hidden" onchange="previewFile()">
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
    // Live Image Upload Preview
    function previewFile() {
        const fileInput = document.getElementById('product_image');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    // Drag and Drop implementation
    document.addEventListener("DOMContentLoaded", () => {
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
                const fileInput = document.getElementById('product_image');
                
                if (files && files.length > 0) {
                    fileInput.files = files;
                    previewFile();
                }
            }, false);
        }
    });
</script>
@endsection
