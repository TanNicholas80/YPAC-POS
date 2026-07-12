@extends('layouts.app')

@section('title', 'Persetujuan Pesanan WA - SIKAS YPAC')

@section('content')
    <div class="flex-1 p-6 md:p-8 space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-gray-400 font-bold uppercase tracking-wider mb-1.5">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#0073E2]">Dashboard</a>
                    <span>/</span>
                    <span class="text-gray-500">Persetujuan WA</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Persetujuan Pesanan WhatsApp</h1>
                <p class="text-gray-500 text-sm mt-0.5">Kelola verifikasi pembayaran dan persetujuan stok untuk transaksi WhatsApp pelanggan.</p>
            </div>
        </div>

        @if(session('success'))
            <!-- Alert Success -->
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3 font-semibold text-sm shadow-sm animate-fade-in">
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

        <!-- Filter Tabs & Stats -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-4">
                <!-- Tabs -->
                <div class="flex items-center bg-gray-50 p-1.5 rounded-2xl border border-gray-200/60">
                    <a href="{{ route('admin.approvals.index', ['status' => 'all', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all {{ $status === 'all' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.approvals.index', ['status' => 'pending', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all flex items-center gap-1.5 {{ $status === 'pending' ? 'bg-white text-amber-600 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        <span>Menunggu</span>
                        @php
                            $pCount = \App\Models\Transaction::where('is_whatsapp', true)->where('status', 'pending')->count();
                        @endphp
                        @if($pCount > 0)
                            <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full text-[10px] font-extrabold">{{ $pCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.approvals.index', ['status' => 'completed', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all {{ $status === 'completed' ? 'bg-white text-green-600 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        Disetujui
                    </a>
                    <a href="{{ route('admin.approvals.index', ['status' => 'cancelled', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all {{ $status === 'cancelled' ? 'bg-white text-red-600 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        Dibatalkan
                    </a>
                </div>

                <!-- Search form -->
                <form action="{{ route('admin.approvals.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelanggan / invoice..."
                            class="w-full pl-10 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-2xl text-xs focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-[#0073E2] hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow-xs transition-colors cursor-pointer">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.approvals.index', ['status' => $status]) }}" class="p-2 bg-gray-150 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors" title="Reset">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle px-6">
                    <div class="overflow-hidden border border-gray-100 rounded-2xl">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/75">
                                <tr>
                                    <th scope="col" class="py-4 px-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th scope="col" class="py-4 px-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th scope="col" class="py-4 px-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Belanja</th>
                                    <th scope="col" class="py-4 px-6 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                                    <th scope="col" class="py-4 px-6 text-center class=text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="py-4 px-6 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="py-4 px-6 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($transactions as $trx)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <!-- Invoice -->
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <span class="font-extrabold text-gray-900 text-sm tracking-tight">{{ $trx->invoice_number }}</span>
                                        </td>
                                        <!-- Customer -->
                                        <td class="py-4 px-6">
                                            <div class="max-w-[200px]">
                                                <p class="font-bold text-gray-900 text-sm truncate">{{ $trx->customer_name }}</p>
                                                <p class="text-xs text-gray-400 truncate mt-0.5" title="{{ $trx->customer_address }}">
                                                    {{ $trx->customer_address }}
                                                </p>
                                            </div>
                                        </td>
                                        <!-- Items list short -->
                                        <td class="py-4 px-6">
                                            <div class="text-xs text-gray-600 space-y-0.5 max-w-[220px]">
                                                @foreach($trx->details->take(2) as $detail)
                                                    <p class="truncate">
                                                        <span class="font-bold text-gray-800">{{ $detail->qty }}x</span> 
                                                        {{ $detail->product->product_name ?? 'Produk dihapus' }}
                                                    </p>
                                                @endforeach
                                                @if($trx->details->count() > 2)
                                                    <p class="text-[10px] text-gray-400 font-bold mt-0.5">+{{ $trx->details->count() - 2 }} produk lainnya</p>
                                                @endif
                                            </div>
                                        </td>
                                        <!-- Total Payment -->
                                        <td class="py-4 px-6 whitespace-nowrap text-right">
                                            <span class="font-extrabold text-gray-900 text-sm">Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Sudah PPN & Ongkir</p>
                                        </td>
                                        <!-- Date -->
                                        <td class="py-4 px-6 whitespace-nowrap text-center text-xs text-gray-500 font-semibold">
                                            {{ $trx->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <!-- Status -->
                                        <td class="py-4 px-6 whitespace-nowrap text-center">
                                            @if($trx->status === 'pending')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                    Menunggu
                                                </span>
                                            @elseif($trx->status === 'completed')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                    Disetujui
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <!-- Action -->
                                        <td class="py-4 px-6 whitespace-nowrap text-center">
                                            <a href="{{ route('admin.approvals.show', $trx->id) }}" 
                                               class="inline-flex items-center gap-1 px-3.5 py-1.5 bg-gray-50 hover:bg-[#0073E2] text-gray-700 hover:text-white border border-gray-200 hover:border-blue-300 font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                                                <span>{{ $trx->status === 'pending' ? 'Proses' : 'Detail' }}</span>
                                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 px-6 text-center text-gray-400 font-medium">
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300">
                                                    <i data-lucide="inbox" class="w-7 h-7"></i>
                                                </div>
                                                <p class="text-sm">Tidak ada transaksi ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
