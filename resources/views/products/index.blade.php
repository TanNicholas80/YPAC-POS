@extends('layouts.app')

@section('title', 'Manajemen Produk - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 overflow-y-auto">
    
    <!-- Top Tabs Header -->
    <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-6 shrink-0">
        <div class="flex gap-6">
            <button onclick="switchTab('product')" id="tab-btn-product"
                class="pb-3 text-lg font-bold text-[#0073E2] border-b-2 border-[#0073E2] transition-all cursor-pointer">
                Daftar Produk
            </button>
            <button onclick="switchTab('category')" id="tab-btn-category"
                class="pb-3 text-lg font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-all cursor-pointer">
                Kategori Produk
            </button>
            <button onclick="switchTab('unit')" id="tab-btn-unit"
                class="pb-3 text-lg font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-all cursor-pointer">
                Satuan Produk
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-green-600 text-sm flex items-center gap-2 max-w-4xl mx-auto w-full no-print">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-center gap-2 max-w-4xl mx-auto w-full no-print">
            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- TAB CONTAINER 1: PRODUCTS -->
    <div id="tab-content-product" class="max-w-6xl w-full mx-auto space-y-6">
        <!-- Actions & Filters -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="w-full sm:max-w-md flex items-center gap-2">
                <input type="hidden" name="tab" value="product">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-450">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk berdasarkan nama..."
                        class="w-full pl-12 pr-4 py-3 bg-white border border-gray-100 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] transition-all font-semibold shadow-sm text-sm">
                </div>
                <button type="submit" class="px-5 py-3 bg-[#0073E2] text-white hover:bg-blue-600 font-bold rounded-2xl transition-colors shadow-sm text-sm cursor-pointer">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('products.index', ['tab' => 'product']) }}" class="p-3 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-2xl transition-colors flex items-center justify-center">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                @endif
            </form>

            <!-- Add Product Button -->
            <a href="{{ route('products.create') }}"
                class="w-full sm:w-auto px-6 py-3.5 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-100 transition-all flex items-center justify-center gap-2 text-sm cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Produk</span>
            </a>
        </div>

        <!-- Products Table Card -->
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="p-5">Visual</th>
                            <th class="p-5">Nama Produk</th>
                            <th class="p-5">Kategori</th>
                            <th class="p-5 text-right">Harga</th>
                            <th class="p-5 text-center">Stok</th>
                            <th class="p-5 text-center">Status</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <!-- Thumbnail -->
                                <td class="p-5 w-20">
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 overflow-hidden">
                                        @if($product->images->first())
                                            <img src="{{ str_starts_with($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset($product->images->first()->image_path) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                                        @else
                                            @if($product->category->category_slug === 'makanan')
                                                <i data-lucide="cookie" class="w-6 h-6 text-gray-400"></i>
                                            @elseif($product->category->category_slug === 'minuman')
                                                <i data-lucide="cup-soda" class="w-6 h-6 text-gray-400"></i>
                                            @else
                                                <i data-lucide="pen-tool" class="w-6 h-6 text-gray-400"></i>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <!-- Name -->
                                <td class="p-5">
                                    <span class="text-gray-900 font-bold block leading-tight">{{ $product->product_name }}</span>
                                    <span class="text-xs text-gray-400 mt-1 font-semibold block">{{ $product->unit->unit_name ?? 'pcs' }}</span>
                                </td>
                                <!-- Category -->
                                <td class="p-5">
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full font-bold">
                                        {{ $product->category->category_name }}
                                    </span>
                                </td>
                                <!-- Price -->
                                <td class="p-5 text-right font-bold text-gray-900">
                                    {{ $product->price_range }}
                                </td>
                                <!-- Stock -->
                                <td class="p-5 text-center">
                                    @if($product->stock <= 5)
                                        <span class="text-red-600 font-extrabold flex items-center justify-center gap-1">
                                            <i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0"></i>
                                            <span>{{ $product->stock }} (Limit)</span>
                                        </span>
                                    @else
                                        <span class="text-gray-700 font-bold">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <!-- Status -->
                                <td class="p-5 text-center">
                                    @if($product->is_active)
                                        <span class="bg-green-50 text-green-600 border border-green-100 text-xs px-2.5 py-1 rounded-full font-bold">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-400 border border-gray-200 text-xs px-2.5 py-1 rounded-full font-bold">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <!-- Actions -->
                                <td class="p-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Preview Detail -->
                                        <a href="{{ route('products.show', $product->id) }}" 
                                            class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50/50 rounded-xl transition-all"
                                            title="Preview Detail">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('products.edit', $product->id) }}" 
                                            class="p-2 text-gray-400 hover:text-[#0073E2] hover:bg-blue-50/50 rounded-xl transition-all">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this, 'produk')" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-gray-400 font-semibold">
                                    <i data-lucide="box" class="w-12 h-12 mx-auto mb-3 stroke-[1.5]"></i>
                                    <span>Tidak ada produk ditemukan</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB CONTAINER 2: CATEGORIES -->
    <div id="tab-content-category" class="max-w-6xl w-full mx-auto hidden">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- Left: Add/Edit Category Form Card (md:col-span-5) -->
            <div class="md:col-span-5 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg leading-tight" id="category-form-title">Tambah Kategori</h3>
                    <span class="text-xs text-gray-400 font-medium">Manajemen klasifikasi produk</span>
                </div>

                <form id="category-form" action="{{ route('products.categories.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="_method" id="category-form-method" value="POST">

                    <div class="space-y-2">
                        <label for="category_name_input" class="text-sm font-semibold text-gray-700">Nama Kategori</label>
                        <input type="text" name="category_name" id="category_name_input" required placeholder="Contoh: Makanan Berat"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-405 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="button" onclick="resetCategoryForm()" id="category-cancel-btn"
                            class="flex-1 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl text-sm transition-colors hidden cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="flex-2 py-3.5 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl text-sm transition-colors shadow-md shadow-blue-100 cursor-pointer">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Categories Table Card (md:col-span-7) -->
            <div class="md:col-span-7 bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-900 text-base leading-tight">Daftar Kategori</h3>
                    <span class="text-xs text-gray-400 font-semibold">Tersedia {{ count($categories) }} kategori terdaftar</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="p-5">Nama Kategori</th>
                                <th class="p-5 text-center">Jumlah Produk</th>
                                <th class="p-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <!-- Name -->
                                    <td class="p-5">
                                        <span class="text-gray-900 font-bold block">{{ $category->category_name }}</span>
                                        <span class="text-xs text-gray-400 mt-0.5 font-medium block">Slug: {{ $category->category_slug }}</span>
                                    </td>
                                    <!-- Product Count -->
                                    <td class="p-5 text-center font-bold text-gray-700">
                                        {{ $category->products_count }} item
                                    </td>
                                    <!-- Actions -->
                                    <td class="p-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit trigger (JS populated) -->
                                            <button type="button" 
                                                onclick="editCategory({{ $category->id }}, '{{ addslashes($category->category_name) }}', '{{ route('products.categories.update', $category->id) }}')"
                                                class="p-2 text-gray-400 hover:text-[#0073E2] hover:bg-blue-50/50 rounded-xl transition-all cursor-pointer">
                                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                                            </button>

                                            <!-- Delete -->
                                            @if($category->products_count > 0)
                                                <button type="button" disabled title="Kategori masih memiliki produk aktif"
                                                    class="p-2 text-gray-250 cursor-not-allowed rounded-xl transition-all">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            @else
                                                 <form action="{{ route('products.categories.destroy', $category->id) }}" method="POST" class="inline">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="button" onclick="confirmDelete(this, 'kategori')" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer">
                                                         <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                     </button>
                                                 </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-10 text-center text-gray-400 font-semibold">
                                        <i data-lucide="folder" class="w-12 h-12 mx-auto mb-3 stroke-[1.5]"></i>
                                        <span>Belum ada kategori terdaftar</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- TAB CONTAINER 3: UNITS -->
    <div id="tab-content-unit" class="max-w-6xl w-full mx-auto hidden">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- Left: Add/Edit Unit Form Card (md:col-span-5) -->
            <div class="md:col-span-5 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg leading-tight" id="unit-form-title">Tambah Satuan</h3>
                    <span class="text-xs text-gray-400 font-medium">Manajemen satuan produk</span>
                </div>

                <form id="unit-form" action="{{ route('products.units.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="_method" id="unit-form-method" value="POST">

                    <div class="space-y-2">
                        <label for="unit_name_input" class="text-sm font-semibold text-gray-700">Nama Satuan</label>
                        <input type="text" name="unit_name" id="unit_name_input" required placeholder="Contoh: Pcs, Kg, Box"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-950 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="button" onclick="resetUnitForm()" id="unit-cancel-btn"
                            class="flex-1 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl text-sm transition-colors hidden cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="flex-2 py-3.5 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl text-sm transition-colors shadow-md shadow-blue-100 cursor-pointer">
                            Simpan Satuan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Units Table Card (md:col-span-7) -->
            <div class="md:col-span-7 bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-900 text-base leading-tight">Daftar Satuan</h3>
                    <span class="text-xs text-gray-400 font-semibold">Tersedia {{ count($units) }} satuan terdaftar</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="p-5">Nama Satuan</th>
                                <th class="p-5 text-center">Jumlah Produk</th>
                                <th class="p-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                            @forelse($units as $unit)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <!-- Name -->
                                    <td class="p-5">
                                        <span class="text-gray-900 font-bold block">{{ $unit->unit_name }}</span>
                                    </td>
                                    <!-- Product Count -->
                                    <td class="p-5 text-center font-bold text-gray-700">
                                        {{ $unit->products_count }} item
                                    </td>
                                    <!-- Actions -->
                                    <td class="p-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit trigger (JS populated) -->
                                            <button type="button" 
                                                onclick="editUnit({{ $unit->id }}, '{{ addslashes($unit->unit_name) }}', '{{ route('products.units.update', $unit->id) }}')"
                                                class="p-2 text-gray-400 hover:text-[#0073E2] hover:bg-blue-50/50 rounded-xl transition-all cursor-pointer">
                                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                                            </button>

                                            <!-- Delete -->
                                            @if($unit->products_count > 0)
                                                <button type="button" disabled title="Satuan masih memiliki produk aktif"
                                                    class="p-2 text-gray-250 cursor-not-allowed rounded-xl transition-all">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            @else
                                                 <form action="{{ route('products.units.destroy', $unit->id) }}" method="POST" class="inline">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="button" onclick="confirmDelete(this, 'satuan')" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer">
                                                         <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                     </button>
                                                 </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-10 text-center text-gray-400 font-semibold">
                                        <i data-lucide="tag" class="w-12 h-12 mx-auto mb-3 stroke-[1.5]"></i>
                                        <span>Belum ada satuan terdaftar</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    // Tab routing check on initial page load
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'product';
        switchTab(activeTab);
    });

    // Switches UI tabs
    function switchTab(tab) {
        const btnProduct = document.getElementById('tab-btn-product');
        const btnCategory = document.getElementById('tab-btn-category');
        const btnUnit = document.getElementById('tab-btn-unit');

        const contentProduct = document.getElementById('tab-content-product');
        const contentCategory = document.getElementById('tab-content-category');
        const contentUnit = document.getElementById('tab-content-unit');

        const activeClass = "pb-3 text-lg font-bold text-[#0073E2] border-b-2 border-[#0073E2] transition-all cursor-pointer";
        const inactiveClass = "pb-3 text-lg font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-all cursor-pointer";

        btnProduct.className = tab === 'product' ? activeClass : inactiveClass;
        btnCategory.className = tab === 'category' ? activeClass : inactiveClass;
        btnUnit.className = tab === 'unit' ? activeClass : inactiveClass;

        contentProduct.classList.toggle('hidden', tab !== 'product');
        contentCategory.classList.toggle('hidden', tab !== 'category');
        contentUnit.classList.toggle('hidden', tab !== 'unit');
    }

    // Load category into Form for updates
    function editCategory(id, name, updateUrl) {
        document.getElementById('category-form-title').innerText = 'Edit Kategori';
        document.getElementById('category-form').action = updateUrl;
        document.getElementById('category-form-method').value = 'PUT';
        document.getElementById('category_name_input').value = name;
        document.getElementById('category-cancel-btn').classList.remove('hidden');
        
        // Scroll slightly to form on mobile viewports
        document.getElementById('category_name_input').focus();
    }

    // Reset Form back to create/store mode
    function resetCategoryForm() {
        document.getElementById('category-form-title').innerText = 'Tambah Kategori';
        document.getElementById('category-form').action = "{{ route('products.categories.store') }}";
        document.getElementById('category-form-method').value = 'POST';
        document.getElementById('category_name_input').value = '';
        document.getElementById('category-cancel-btn').classList.add('hidden');
    }

    // Load unit into Form for updates
    function editUnit(id, name, updateUrl) {
        document.getElementById('unit-form-title').innerText = 'Edit Satuan';
        document.getElementById('unit-form').action = updateUrl;
        document.getElementById('unit-form-method').value = 'PUT';
        document.getElementById('unit_name_input').value = name;
        document.getElementById('unit-cancel-btn').classList.remove('hidden');
        
        document.getElementById('unit_name_input').focus();
    }

    // Reset Unit Form back to create/store mode
    function resetUnitForm() {
        document.getElementById('unit-form-title').innerText = 'Tambah Satuan';
        document.getElementById('unit-form').action = "{{ route('products.units.store') }}";
        document.getElementById('unit-form-method').value = 'POST';
        document.getElementById('unit_name_input').value = '';
        document.getElementById('unit-cancel-btn').classList.add('hidden');
    }

    // Reusable SweetAlert2 confirmation dialog for deletion
    function confirmDelete(button, type) {
        Swal.fire({
            title: `Hapus ${type.charAt(0).toUpperCase() + type.slice(1)}?`,
            text: `Apakah Anda yakin ingin menghapus ${type} ini? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>
@endsection
