@extends('layouts.app')

@section('title', 'Laporan & Insight - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 overflow-y-auto">

    <!-- Top Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-4 mb-6 shrink-0 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-7 h-7 text-[#0073E2]"></i>
                <span>Laporan & Insight Penjualan</span>
            </h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Analisis performa penjualan, kontrol inventori stok, dan riwayat transaksi kasir.</p>
        </div>
    </div>

    <!-- 1. STATS OVERVIEW CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 shrink-0">
        <!-- Revenue Card -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0073E2]">
                <i data-lucide="banknote" class="w-7 h-7"></i>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Total Pendapatan</span>
                <span class="text-2xl font-black text-gray-900 mt-1 block">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Transactions Count Card -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                <i data-lucide="shopping-bag" class="w-7 h-7"></i>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Total Transaksi</span>
                <span class="text-2xl font-black text-gray-900 mt-1 block">
                    {{ number_format($totalTransactions, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Items Sold Card -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600">
                <i data-lucide="package" class="w-7 h-7"></i>
            </div>
            <div>
                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Total Produk Terjual</span>
                <span class="text-2xl font-black text-gray-900 mt-1 block">
                    {{ number_format($totalItemsSold, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- 2. TWO-COLUMN INSIGHTS (BEST SELLERS & LOW STOCK) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        
        <!-- Left: Best Sellers (lg:col-span-7) -->
        <div class="lg:col-span-7 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
            <div class="mb-4">
                <div class="flex items-center gap-2 mb-1">
                    <i data-lucide="trending-up" class="w-5 h-5 text-[#0073E2]"></i>
                    <h3 class="font-bold text-gray-900 text-lg leading-tight">Barang Terlaris</h3>
                </div>
                <span class="text-xs text-gray-400 font-semibold">Top 5 produk dengan jumlah penjualan terbanyak</span>
            </div>

            <div class="space-y-5 flex-1 mt-4">
                @forelse($bestSellers as $index => $item)
                    @php
                        $percentage = ($item->total_sold / $maxSold) * 100;
                    @endphp
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-lg bg-gray-50 flex items-center justify-center text-xs font-black text-[#0073E2] border border-gray-100">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <span class="font-bold text-gray-800 leading-tight block text-sm">{{ $item->product->product_name }}</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase block">{{ $item->product->category->category_name }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-gray-900 block text-sm">{{ $item->total_sold }} {{ $item->product->unit->unit_name ?? 'pcs' }}</span>
                                <span class="text-[10px] text-gray-400 font-bold block">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <!-- Progress Bar representing relative sells -->
                        <div class="w-full bg-gray-50 rounded-full h-2 overflow-hidden border border-gray-50">
                            <div class="bg-[#0073E2] h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="h-48 flex flex-col items-center justify-center text-center text-gray-400 font-semibold">
                        <i data-lucide="cookie" class="w-10 h-10 mb-2 stroke-[1.5]"></i>
                        <span class="text-sm">Belum ada data penjualan barang.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Low Stock Alert (lg:col-span-5) -->
        <div class="lg:col-span-5 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col">
            <div class="mb-4">
                <div class="flex items-center gap-2 mb-1">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                    <h3 class="font-bold text-gray-900 text-lg leading-tight">Kontrol Inventori & Stok</h3>
                </div>
                <span class="text-xs text-gray-400 font-semibold">Daftar produk dengan persediaan kritis (&le; 10 unit)</span>
            </div>

            <div class="flex-1 overflow-y-auto max-h-[320px] pr-1 mt-4 space-y-3">
                @forelse($lowStockProducts as $product)
                    <div class="p-3.5 rounded-2xl border flex items-center justify-between transition-colors {{ $product->stock <= 3 ? 'bg-red-50 border-red-100' : 'bg-amber-50 border-amber-100' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $product->stock <= 3 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }}">
                                <i data-lucide="{{ $product->stock <= 3 ? 'alert-octagon' : 'alert-circle' }}" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block leading-tight text-sm">{{ $product->product_name }}</span>
                                <span class="text-[10px] text-gray-500 font-semibold block mt-0.5">{{ $product->category->category_name }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="text-xs font-bold block uppercase tracking-wider text-gray-400">Sisa Stok</span>
                                <span class="text-base font-black leading-tight block {{ $product->stock <= 3 ? 'text-red-650' : 'text-amber-655' }}">
                                    {{ $product->stock }} {{ $product->unit->unit_name ?? 'pcs' }}
                                </span>
                            </div>
                            <a href="{{ route('products.edit', $product->id) }}" 
                               class="p-2 bg-white rounded-xl border border-gray-150 hover:bg-gray-50 transition-colors text-gray-650"
                               title="Tambah Stok">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center text-green-600 font-bold p-8">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 mb-3 border border-green-100">
                            <i data-lucide="check" class="w-6 h-6"></i>
                        </div>
                        <span class="text-sm">Semua stok aman!</span>
                        <span class="text-xs text-gray-400 font-semibold mt-1">Tidak ada produk dengan stok &le; 10 unit.</span>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- 3. TRANSACTION HISTORY LIST -->
    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col flex-1">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <i data-lucide="history" class="w-5 h-5 text-[#0073E2]"></i>
                    <h3 class="font-bold text-gray-900 text-lg leading-tight">Data Riwayat Transaksi</h3>
                </div>
                <span class="text-xs text-gray-400 font-semibold">Cari dan filter log seluruh transaksi toko</span>
            </div>

            <!-- Filters Container -->
            <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <!-- Search input -->
                <div class="relative w-full sm:w-56">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Invoice..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-100 rounded-2xl text-xs text-gray-950 placeholder-gray-450 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold">
                </div>

                <!-- Start Date -->
                <div class="relative w-full sm:w-40">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" title="Mulai Tanggal"
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-100 rounded-2xl text-xs text-gray-955 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold">
                </div>

                <!-- End Date -->
                <div class="relative w-full sm:w-40">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" title="Hingga Tanggal"
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-100 rounded-2xl text-xs text-gray-955 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold">
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-initial px-5 py-2.5 bg-[#0073E2] hover:bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-sm transition-colors cursor-pointer">
                        Filter
                    </button>
                    @if(request('search') || request('start_date') || request('end_date'))
                        <a href="{{ route('reports.index') }}" class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-2xl transition-colors flex items-center justify-center">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table View -->
        <div class="border border-gray-100 rounded-2xl overflow-hidden mb-4 shadow-sm bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="p-4">Tanggal & Waktu</th>
                            <th class="p-4">No. Invoice</th>
                            <th class="p-4">Kasir</th>
                            <th class="p-4 text-center">Metode Pembayaran</th>
                            <th class="p-4 text-right">Total Transaksi</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50/40 transition-colors">
                                <!-- Date & Time -->
                                <td class="p-4">
                                    <span class="text-gray-900 block leading-tight text-sm">{{ $trx->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-400 mt-1 font-semibold block">{{ $trx->created_at->format('H:i') }} WIB</span>
                                </td>
                                <!-- Invoice Number -->
                                <td class="p-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-gray-900 font-bold block text-sm">{{ $trx->invoice_number }}</span>
                                        <button onclick="copyToClipboard('{{ $trx->invoice_number }}')" class="text-gray-400 hover:text-gray-600 focus:outline-none p-1 rounded hover:bg-gray-100 cursor-pointer" title="Salin Invoice">
                                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                </td>
                                <!-- Cashier -->
                                <td class="p-4">
                                    <span class="text-gray-800 text-sm">{{ $trx->user->name ?? 'Kasir YPAC' }}</span>
                                </td>
                                <!-- Payment Method -->
                                <td class="p-4 text-center">
                                    @if($trx->payment_method === 'cash')
                                        <span class="bg-green-50 text-green-600 border border-green-100 text-xs px-2.5 py-1 rounded-full font-bold">
                                            Tunai
                                        </span>
                                    @elseif($trx->payment_method === 'transfer_bank')
                                        <span class="bg-blue-50 text-blue-600 border border-blue-100 text-xs px-2.5 py-1 rounded-full font-bold">
                                            Transfer Bank
                                        </span>
                                    @else
                                        <span class="bg-purple-50 text-purple-600 border border-purple-100 text-xs px-2.5 py-1 rounded-full font-bold">
                                            QRIS
                                        </span>
                                    @endif
                                </td>
                                <!-- Total -->
                                <td class="p-4 text-right font-black text-gray-900 text-sm">
                                    Rp {{ number_format($trx->total, 0, ',', '.') }}
                                </td>
                                <!-- Actions -->
                                <td class="p-4 text-center">
                                    <button type="button" 
                                            onclick='openDetailModal(@json($trx))'
                                            class="px-4 py-2 bg-gray-50 hover:bg-[#EAF2FC] hover:text-[#0073E2] text-gray-600 text-xs font-bold rounded-xl border border-gray-150 hover:border-[#0073E2]/25 transition-all flex items-center justify-center gap-1.5 mx-auto cursor-pointer">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        <span>Detail</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 font-semibold">
                                    <i data-lucide="receipt" class="w-12 h-12 mx-auto mb-3 stroke-[1.5]"></i>
                                    <span>Tidak ada riwayat transaksi ditemukan</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-auto pt-3">
            {{ $transactions->links() }}
        </div>
    </div>

</div>

<!-- DETAILED TRANSACTION MODAL -->
<div id="trx-detail-modal" class="fixed inset-0 z-50 bg-black/55 backdrop-blur-xs flex items-center justify-center p-4 hidden" onclick="event.target.id === 'trx-detail-modal' ? closeDetailModal() : null">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="modal-container">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <div>
                <h3 class="text-lg font-black text-gray-900">Detail Transaksi</h3>
                <span class="text-xs text-gray-400 font-bold block mt-1 uppercase" id="modal-invoice-num">TRX-XXXXX</span>
            </div>
            <button onclick="closeDetailModal()" class="p-2 text-gray-450 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1 max-h-[70vh]">
            <!-- Metadata details -->
            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 text-xs font-semibold text-gray-700">
                <div>
                    <span class="text-gray-400 block mb-0.5">Waktu Transaksi</span>
                    <span id="modal-date-val" class="text-gray-900 font-bold block">05 Jul 2026, 12:00</span>
                </div>
                <div>
                    <span class="text-gray-400 block mb-0.5">Metode Pembayaran</span>
                    <span id="modal-payment-val" class="mt-0.5 block">QRIS</span>
                </div>
                <div>
                    <span class="text-gray-400 block mb-0.5">Petugas Kasir</span>
                    <span id="modal-cashier-val" class="text-gray-900 font-bold block">Admin</span>
                </div>
                <div>
                    <span class="text-gray-400 block mb-0.5">Status Transaksi</span>
                    <span class="bg-green-50 text-green-600 border border-green-100 text-[10px] px-2 py-0.5 rounded-full font-bold inline-block">completed</span>
                </div>
            </div>

            <!-- Items Table List -->
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Item Belanja</h4>
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-white">
                    <table class="w-full text-left text-xs font-semibold text-gray-700 border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase font-bold text-gray-450">
                                <th class="p-3.5">Nama Produk</th>
                                <th class="p-3.5 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal-items-body" class="divide-y divide-gray-50">
                            <!-- Items populated dynamic via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Calculations totals -->
            <div class="space-y-2 border-t border-gray-100 pt-4">
                <div class="flex justify-between text-xs text-gray-500 font-semibold">
                    <span>Subtotal:</span>
                    <span id="modal-subtotal-val" class="text-gray-900">Rp 0</span>
                </div>
                <div class="flex justify-between text-xs text-gray-500 font-semibold">
                    <span>Pajak (10%):</span>
                    <span id="modal-tax-val" class="text-gray-900">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-gray-900 font-black pt-1">
                    <span>Total Pembayaran:</span>
                    <span id="modal-total-val" class="text-[#0073E2]">Rp 0</span>
                </div>
            </div>

            <!-- Cash Details or QRIS Proof Upload -->
            <div class="border-t border-gray-100 pt-4" id="modal-payment-detail-section">
                <!-- Populated dynamic based on cash / qris -->
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 border-t border-gray-100 flex items-center justify-end bg-gray-50/50">
            <button onclick="closeDetailModal()" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-750 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                Tutup
            </button>
        </div>
</div>

<script>
    // Copy Invoice Helper
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                title: 'Disalin!',
                text: 'Invoice ' + text + ' berhasil disalin ke clipboard.',
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-2xl shadow-lg border border-green-100 bg-white'
                }
            });
        }, function(err) {
            console.error('Gagal menyalin text: ', err);
        });
    }

    // Modal Interaction Functions
    function openDetailModal(trx) {
        const modal = document.getElementById('trx-detail-modal');
        const container = document.getElementById('modal-container');

        // Set metadata
        document.getElementById('modal-invoice-num').innerText = trx.invoice_number;
        
        // Format date string
        const date = new Date(trx.created_at);
        const dateStr = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + 
                        date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
        document.getElementById('modal-date-val').innerText = dateStr;
        document.getElementById('modal-cashier-val').innerText = trx.user ? trx.user.name : 'Kasir YPAC';

        // Payment method badge
        const payVal = document.getElementById('modal-payment-val');
        if(trx.payment_method === 'cash') {
            payVal.innerHTML = `<span class="bg-green-50 text-green-600 border border-green-100 text-[10px] px-2.5 py-0.5 rounded-full font-bold">Tunai</span>`;
        } else if(trx.payment_method === 'transfer_bank') {
            payVal.innerHTML = `<span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] px-2.5 py-0.5 rounded-full font-bold">Transfer Bank</span>`;
        } else {
            payVal.innerHTML = `<span class="bg-purple-50 text-purple-600 border border-purple-100 text-[10px] px-2.5 py-0.5 rounded-full font-bold">QRIS</span>`;
        }

        // Render table items
        const tbody = document.getElementById('modal-items-body');
        tbody.innerHTML = '';
        
        trx.details.forEach(item => {
            const productName = item.product ? item.product.product_name : 'Produk Terhapus';
            const unitName = (item.product && item.product.unit) ? item.product.unit.unit_name : 'pcs';
            
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="p-3.5 text-gray-805">
                    <span class="font-bold block text-xs leading-tight">${productName}</span>
                    <span class="text-[10px] text-gray-400 font-semibold block mt-0.5">${item.qty} ${unitName} x Rp ${formatRupiah(item.price)}</span>
                </td>
                <td class="p-3.5 text-right font-bold text-gray-900 text-xs">
                    Rp ${formatRupiah(item.subtotal)}
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Set math values
        document.getElementById('modal-subtotal-val').innerText = 'Rp ' + formatRupiah(trx.subtotal);
        document.getElementById('modal-tax-val').innerText = 'Rp ' + formatRupiah(trx.tax);
        document.getElementById('modal-total-val').innerText = 'Rp ' + formatRupiah(trx.total);

        // Render payment method specific details (cash change vs QRIS image proof)
        const paymentDetail = document.getElementById('modal-payment-detail-section');
        paymentDetail.innerHTML = '';

        if(trx.payment_method === 'cash') {
            paymentDetail.innerHTML = `
                <div class="space-y-2 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div class="flex justify-between text-xs text-gray-500 font-semibold">
                        <span>Nominal Uang Tunai:</span>
                        <span class="text-gray-900 font-bold">Rp ${formatRupiah(trx.amount_paid)}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-550 font-semibold border-t border-gray-200/60 pt-2">
                        <span>Kembalian:</span>
                        <span class="text-green-600 font-black text-sm">Rp ${formatRupiah(trx.change_amount)}</span>
                    </div>
                </div>
            `;
        } else {
            const imgPath = trx.payment_proof || trx.qris_image;
            if(imgPath) {
                const imgUrl = imgPath.startsWith('http') ? imgPath : `${window.location.origin}/${imgPath}`;
                paymentDetail.innerHTML = `
                    <div class="space-y-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Bukti Transfer / QRIS:</span>
                        <div class="w-full bg-gray-50 p-2 border border-gray-100 rounded-2xl flex items-center justify-center overflow-hidden">
                            <img src="${imgUrl}" alt="Bukti Pembayaran" class="max-h-56 object-contain rounded-xl shadow-xs">
                        </div>
                    </div>
                `;
            } else {
                paymentDetail.innerHTML = `
                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-2xl text-center text-xs text-gray-400 font-semibold italic">
                        Bukti pembayaran tidak diunggah oleh kasir.
                    </div>
                `;
            }
        }

        // Trigger animations
        modal.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 15);
    }

    function closeDetailModal() {
        const modal = document.getElementById('trx-detail-modal');
        const container = document.getElementById('modal-container');

        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    function formatRupiah(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }
</script>
@endsection
