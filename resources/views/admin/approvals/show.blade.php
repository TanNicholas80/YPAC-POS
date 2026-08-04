@extends('layouts.app')

@section('title', 'Tracking & Detail Transaksi WA - SIKAS YPAC')

@section('content')
    <div class="flex-1 p-6 md:p-8 space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex items-center gap-2 text-xs text-gray-400 font-bold uppercase tracking-wider">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0073E2]">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.approvals.index') }}" class="hover:text-[#0073E2]">Tracking Transaksi WA</a>
            <span>/</span>
            <span class="text-gray-500">Detail</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Detail Transaksi {{ $transaction->invoice_number }}</h1>
                <p class="text-gray-500 text-sm mt-0.5">Tinjau bukti pembayaran dari pelanggan dan perbarui status pengiriman barang.</p>
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
                        <span>Informasi Pemesan</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Nama Lengkap</p>
                            <p class="font-extrabold text-gray-900 mt-1">{{ $transaction->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Nomor WhatsApp</p>
                            @php
                                $waUrl = \App\Http\Controllers\AdminApprovalController::generateWhatsAppUrl($transaction);
                            @endphp
                            <div class="flex items-center gap-2 mt-1">
                                <span class="font-bold text-[#0073E2] flex items-center gap-1.5">
                                    <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                                    <span>{{ $transaction->customer_phone ?? '-' }}</span>
                                </span>
                                @if($waUrl)
                                    <a href="{{ $waUrl }}" target="_blank" 
                                       class="px-2.5 py-1 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 rounded-xl transition-all font-bold text-xs flex items-center gap-1">
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>Chat WA</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Tanggal Checkout</p>
                            <p class="font-bold text-gray-800 mt-1">{{ $transaction->created_at->format('d F Y - H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Catatan Tambahan</p>
                            <p class="font-semibold text-gray-800 mt-1 italic">{{ $transaction->customer_notes ?: 'Tidak ada catatan' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-400 font-semibold text-xs uppercase tracking-wider">Alamat Pengiriman</p>
                            <p class="font-medium text-gray-800 mt-1 bg-gray-50 p-3.5 rounded-2xl border border-gray-100 leading-relaxed">{{ $transaction->customer_address }}</p>
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
                                        <th class="py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Qty</th>
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
                                                        @if($item->variant_name)
                                                            <span class="inline-block bg-blue-50 text-[#0073E2] font-bold text-[10px] px-2 py-0.5 rounded-lg mt-0.5">Varian: {{ $item->variant_name }}</span>
                                                        @endif
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
                        <div class="flex items-baseline justify-between w-full max-w-xs border-t border-gray-100 pt-3 mt-1">
                            <span class="text-base font-extrabold text-gray-900">Total Pembayaran</span>
                            <span class="text-xl font-extrabold text-[#0073E2]">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Delivery Tracking & Payment Proof Inspection) -->
            <div class="space-y-6">
                <!-- Delivery Tracking Update Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                        <i data-lucide="truck" class="w-5 h-5 text-[#0073E2]"></i>
                        <span>Tracking Status Pengiriman</span>
                    </h2>

                    <form action="{{ route('admin.approvals.delivery_status', $transaction->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Update Status Barang</label>
                            <select name="delivery_status" required {{ $transaction->delivery_status === 'sudah_terkirim' ? 'disabled' : '' }}
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-[#0073E2] rounded-xl text-sm font-bold text-gray-800 focus:outline-none transition-colors {{ $transaction->delivery_status === 'sudah_terkirim' ? 'cursor-not-allowed opacity-80' : '' }}">
                                <option value="belum_dikirim" {{ $transaction->delivery_status === 'belum_dikirim' ? 'selected' : '' }} {{ $transaction->delivery_status !== 'belum_dikirim' ? 'disabled' : '' }}>⏳ Belum Dikirim</option>
                                <option value="sedang_dikirim" {{ $transaction->delivery_status === 'sedang_dikirim' ? 'selected' : '' }} {{ $transaction->delivery_status === 'sudah_terkirim' ? 'disabled' : '' }}>🚚 Sedang Dikirim</option>
                                <option value="sudah_terkirim" {{ $transaction->delivery_status === 'sudah_terkirim' ? 'selected' : '' }}>✅ Sudah Terkirim (Selesai)</option>
                            </select>
                        </div>

                        @if($transaction->delivery_status !== 'sudah_terkirim')
                            <button type="submit" class="w-full py-3.5 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold text-sm rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                <span>Simpan Status Pengiriman</span>
                            </button>
                        @else
                            <div class="p-3 bg-green-50 border border-green-200 rounded-xl text-center text-xs font-bold text-green-700 flex items-center justify-center gap-1.5">
                                <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                <span>Status Pengiriman Sudah Selesai (Final)</span>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Customer Payment Proof Card -->
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-50">
                        <i data-lucide="credit-card" class="w-5 h-5 text-[#0073E2]"></i>
                        <span>Bukti Pembayaran Pelanggan</span>
                    </h2>

                    <div class="space-y-3">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Metode Pembayaran</span>
                            <span class="font-extrabold text-gray-900 text-sm mt-0.5 block">
                                {{ $transaction->payment_method === 'transfer_bank' ? 'Bank Jateng (Transfer Bank)' : 'QRIS Code' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-2">Foto / Screenshot Bukti Transfer</span>
                            @if($transaction->payment_proof)
                                <a href="{{ $transaction->payment_proof }}" target="_blank" class="group relative block rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 shadow-inner max-h-64">
                                    <img src="{{ $transaction->payment_proof }}" alt="Bukti Pembayaran" class="w-full h-full object-contain max-h-64 group-hover:scale-[1.03] transition-transform duration-300">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-1">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                        <span>Buka Gambar Asli</span>
                                    </div>
                                </a>
                            @else
                                <div class="p-4 bg-gray-50 rounded-2xl text-center text-gray-400 text-xs font-semibold border border-gray-100">
                                    Bukti pembayaran belum diunggah.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
