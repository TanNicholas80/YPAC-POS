@extends('layouts.app')

@section('title', 'Detail Persetujuan Pesanan WA - SIKAS YPAC')

@section('content')
    <div class="flex-1 p-6 md:p-8 space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex items-center gap-2 text-xs text-gray-400 font-bold uppercase tracking-wider">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0073E2]">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.approvals.index') }}" class="hover:text-[#0073E2]">Persetujuan WA</a>
            <span>/</span>
            <span class="text-gray-500">Detail</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Detail Persetujuan</h1>
                <p class="text-gray-500 text-sm mt-0.5">Tinjau pesanan, pilih metode pembayaran, dan unggah bukti transaksi pembeli.</p>
            </div>
            <a href="{{ route('admin.approvals.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-bold text-xs rounded-xl shadow-xs transition-colors cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>

        @if(session('success'))
            <!-- Alert Success -->
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3 font-semibold text-sm shadow-sm">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <!-- Alert Errors -->
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex flex-col gap-1 font-semibold text-sm shadow-sm">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Panel (Order Details) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer info card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                        <i data-lucide="user" class="w-5 h-5 text-[#0073E2]"></i>
                        <span>Informasi Pelanggan</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Nama Lengkap</p>
                            <p class="font-extrabold text-gray-900 mt-1">{{ $transaction->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Tanggal Checkout</p>
                            <p class="font-bold text-gray-800 mt-1">{{ $transaction->created_at->format('d F Y - H:i') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Alamat Pengiriman & Catatan</p>
                            <p class="font-medium text-gray-800 mt-1 bg-gray-50 p-3 rounded-2xl border border-gray-100 leading-relaxed">{{ $transaction->customer_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-[#0073E2]"></i>
                        <span>Detail Item Belanja</span>
                    </h2>
                    <div class="overflow-x-auto -mx-6">
                        <div class="inline-block min-w-full align-middle px-6">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr>
                                        <th class="py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                                        <th class="py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Harga</th>
                                        <th class="py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Quantity</th>
                                        <th class="py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($transaction->details as $item)
                                        <tr>
                                            <td class="py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    @if($item->product && $item->product->images->first())
                                                        <img src="{{ str_starts_with($item->product->images->first()->image_path, 'http') ? $item->product->images->first()->image_path : asset($item->product->images->first()->image_path) }}" alt="" class="w-12 h-12 object-cover rounded-xl border border-gray-100 bg-gray-50">
                                                    @else
                                                        <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-300">
                                                            <i data-lucide="image" class="w-5 h-5"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-extrabold text-gray-900 text-sm leading-snug">{{ $item->product->product_name ?? 'Produk dihapus' }}</p>
                                                        <p class="text-xs text-gray-400 mt-0.5">Kategori: {{ $item->product->category->category_name ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 text-right whitespace-nowrap font-semibold text-sm text-gray-800">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="py-4 text-center whitespace-nowrap font-extrabold text-sm text-gray-900">
                                                {{ $item->qty }}
                                            </td>
                                            <td class="py-4 text-right whitespace-nowrap font-extrabold text-sm text-gray-900">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment summary calculation -->
                    <div class="border-t border-gray-100 pt-4 flex flex-col items-end space-y-2">
                        <div class="flex items-center justify-between w-full max-w-xs text-sm">
                            <span class="text-gray-400 font-semibold">Subtotal</span>
                            <span class="font-extrabold text-gray-800">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between w-full max-w-xs text-sm">
                            <span class="text-gray-400 font-semibold">PPN (10%)</span>
                            <span class="font-extrabold text-gray-800">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between w-full max-w-xs text-sm">
                            <span class="text-gray-400 font-semibold">Ongkos Kirim</span>
                            <span class="font-extrabold text-gray-800">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-baseline justify-between w-full max-w-xs border-t border-gray-100 pt-3 mt-1">
                            <span class="text-base font-extrabold text-gray-900">Grand Total</span>
                            <span class="text-xl font-extrabold text-[#0073E2]">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Approval Processing Form) -->
            <div class="space-y-6">
                <!-- Status Badge Header -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                        <i data-lucide="info" class="w-5 h-5 text-[#0073E2]"></i>
                        <span>Status Transaksi</span>
                    </h2>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-500">Status Saat Ini</span>
                        @if($transaction->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 shadow-inner">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        @elseif($transaction->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>

                @if($transaction->status === 'pending')
                    <!-- Action Form (Approve) -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                            <i data-lucide="check-square" class="w-5 h-5 text-green-600"></i>
                            <span>Proses Persetujuan</span>
                        </h2>

                        <form id="approve-form" action="{{ route('admin.approvals.approve', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <!-- Payment Method Select -->
                            <div>
                                <label for="payment_method" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                                <select name="payment_method" id="payment_method" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-[#0073E2] rounded-xl text-sm font-bold text-gray-800 focus:outline-none transition-colors">
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="transfer_bank" {{ old('payment_method') === 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="qris" {{ old('payment_method') === 'qris' ? 'selected' : '' }}>QRIS</option>
                                </select>
                            </div>

                            <!-- Payment Proof Image Upload -->
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Unggah Bukti Bayar</label>
                                <div class="relative border-2 border-dashed border-gray-200 hover:border-blue-400 rounded-2xl p-4 transition-colors flex flex-col items-center justify-center bg-gray-50 cursor-pointer hover:bg-blue-50/10">
                                    <input type="file" name="payment_proof" id="payment_proof" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                                    
                                    <div id="upload-placeholder" class="flex flex-col items-center text-center space-y-2">
                                        <i data-lucide="image" class="w-8 h-8 text-gray-300"></i>
                                        <p class="text-xs font-bold text-gray-600">Pilih berkas foto bukti bayar</p>
                                        <p class="text-[10px] text-gray-400 font-medium">JPEG, PNG, WEBP (Max 4MB)</p>
                                    </div>
                                    
                                    <!-- Image Preview container -->
                                    <img id="image-preview" src="#" alt="Pratinjau Bukti Bayar" class="hidden max-h-48 object-contain rounded-xl border border-gray-200">
                                </div>
                            </div>

                            <!-- Submit Approve -->
                            <button type="submit" class="w-full py-4 bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-green-100 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="check" class="w-5 h-5"></i>
                                <span>Setujui (Approved)</span>
                            </button>
                        </form>

                        <!-- Reject Action (Separate Form to prevent submit collisions) -->
                        <div class="pt-2 border-t border-gray-50">
                            <form id="reject-form" action="{{ route('admin.approvals.reject', $transaction->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3.5 bg-white hover:bg-red-50 hover:text-red-700 text-red-600 border border-red-200 active:scale-[0.98] font-bold text-sm rounded-2xl shadow-xs transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                    <span>Tolak Transaksi (Rejected)</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Processed Information Card -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                            <i data-lucide="archive" class="w-5 h-5 text-gray-600"></i>
                            <span>Detail Pemrosesan</span>
                        </h2>

                        <div class="space-y-3.5 text-sm">
                            <div>
                                <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Diproses Oleh</p>
                                <p class="font-bold text-gray-800 mt-0.5">{{ $transaction->user->name ?? 'Sistem / Tidak Diketahui' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Tanggal Diproses</p>
                                <p class="font-bold text-gray-800 mt-0.5">{{ $transaction->updated_at->format('d M Y - H:i') }}</p>
                            </div>
                            
                            @if($transaction->status === 'completed')
                                <div>
                                    <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Metode Pembayaran</p>
                                    <p class="font-extrabold text-[#0073E2] mt-0.5 uppercase">
                                        {{ $transaction->payment_method === 'transfer_bank' ? 'Transfer Bank' : $transaction->payment_method }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider mb-2">Bukti Pembayaran</p>
                                    @if($transaction->payment_proof)
                                        <a href="{{ $transaction->payment_proof }}" target="_blank" class="group relative block rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 shadow-inner max-h-56">
                                            <img src="{{ $transaction->payment_proof }}" alt="Bukti Pembayaran" class="w-full h-full object-contain max-h-56 group-hover:scale-[1.03] transition-transform duration-300">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-1">
                                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                                <span>Buka Tab Baru</span>
                                            </div>
                                        </a>
                                    @else
                                        <p class="text-gray-400 italic">Bukti pembayaran tidak tersedia.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($transaction->status === 'pending')
        <script>
            // JS Preview Uploaded Proof of Payment
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('upload-placeholder');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '#';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
            }

            // SweetAlert2 Form Confirmation interceptors
            document.addEventListener('DOMContentLoaded', function () {
                const approveForm = document.getElementById('approve-form');
                if (approveForm) {
                    approveForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        
                        const method = document.getElementById('payment_method').value;
                        const file = document.getElementById('payment_proof').files.length;
                        
                        if (!method) {
                            Swal.fire({
                                title: 'Perhatian!',
                                text: 'Pilih metode pembayaran terlebih dahulu.',
                                icon: 'warning',
                                confirmButtonColor: '#0073E2',
                                customClass: { popup: 'rounded-3xl' }
                            });
                            return;
                        }
                        if (file === 0) {
                            Swal.fire({
                                title: 'Perhatian!',
                                text: 'Silakan pilih berkas bukti pembayaran terlebih dahulu.',
                                icon: 'warning',
                                confirmButtonColor: '#0073E2',
                                customClass: { popup: 'rounded-3xl' }
                            });
                            return;
                        }

                        Swal.fire({
                            title: 'Setujui Transaksi?',
                            text: 'Stok produk di gudang akan otomatis dikurangi berdasarkan pesanan.',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#10B981',
                            cancelButtonColor: '#6B7280',
                            confirmButtonText: 'Ya, Setujui!',
                            cancelButtonText: 'Batal',
                            customClass: { popup: 'rounded-3xl' }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                approveForm.submit();
                            }
                        });
                    });
                }

                const rejectForm = document.getElementById('reject-form');
                if (rejectForm) {
                    rejectForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Tolak Transaksi?',
                            text: 'Transaksi ini akan dibatalkan secara permanen.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#EF4444',
                            cancelButtonColor: '#6B7280',
                            confirmButtonText: 'Ya, Tolak!',
                            cancelButtonText: 'Batal',
                            customClass: { popup: 'rounded-3xl' }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                rejectForm.submit();
                            }
                        });
                    });
                }
            });
        </script>
    @endif
@endsection
