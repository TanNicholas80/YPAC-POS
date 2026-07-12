@extends('layouts.app')

@section('title', 'Dashboard - SIKAS YPAC')

@section('content')
    <div class="flex-1 flex flex-col items-center justify-center p-8 md:p-12">
        @php
            $pendingCount = \App\Models\Transaction::where('is_whatsapp', true)->where('status', 'pending')->count();
        @endphp

        @if($pendingCount > 0)
            <!-- Quick Notification Alert for Pending Approvals -->
            <div class="w-full max-w-5xl mb-8 bg-amber-50 border border-amber-200 rounded-3xl p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0 animate-pulse">
                        <i data-lucide="bell" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-amber-900 text-base md:text-lg">Persetujuan Transaksi Baru</h3>
                        <p class="text-amber-700 text-xs md:text-sm mt-0.5">Ada <strong>{{ $pendingCount }} transaksi WhatsApp</strong> yang menunggu persetujuan Anda untuk memotong stok gudang.</p>
                    </div>
                </div>
                <a href="{{ route('admin.approvals.index') }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs md:text-sm rounded-xl shadow-md shadow-amber-100 transition-all flex items-center gap-2 flex-shrink-0 cursor-pointer">
                    <span>Lihat & Proses</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endif

        <!-- Welcome Heading -->
        <div class="text-center max-w-xl mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 tracking-tight">Welcome Back</h1>
            <p class="text-gray-500 text-base">Select a module to manage your terminal operations efficiently.</p>
        </div>

        <!-- Modules Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
            <!-- Sales Card (Active Link) -->
            <a href="{{ route('sales.index') }}"
                class="bg-white border border-gray-100 rounded-3xl p-8 flex flex-col items-center text-center hover:shadow-xl hover:shadow-gray-100 hover:-translate-y-1 transition-all duration-300 group">
                <div
                    class="w-20 h-20 rounded-full bg-[#EAF2FC] flex items-center justify-center text-[#0073E2] mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i data-lucide="shopping-cart" class="w-9 h-9"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Sales</h2>
                <p class="text-gray-500 text-sm font-medium">Manage transactions</p>
            </a>

            <!-- Product Card (Active Link) -->
            <a href="{{ route('products.index') }}"
                class="bg-white border border-gray-100 rounded-3xl p-8 flex flex-col items-center text-center hover:shadow-xl hover:shadow-gray-100 hover:-translate-y-1 transition-all duration-300 group">
                <div
                    class="w-20 h-20 rounded-full bg-[#EAF2FC] flex items-center justify-center text-[#0073E2] mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i data-lucide="box" class="w-9 h-9"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Product</h2>
                <p class="text-gray-500 text-sm font-medium">Inventory control</p>
            </a>

            <!-- Reports Card (Active Link) -->
            <a href="{{ route('reports.index') }}"
                class="bg-white border border-gray-100 rounded-3xl p-8 flex flex-col items-center text-center hover:shadow-xl hover:shadow-gray-100 hover:-translate-y-1 transition-all duration-300 group">
                <div
                    class="w-20 h-20 rounded-full bg-[#EAF2FC] flex items-center justify-center text-[#0073E2] mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i data-lucide="bar-chart-2" class="w-9 h-9"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Reports</h2>
                <p class="text-gray-500 text-sm font-medium">Analytics & data</p>
            </a>
        </div>
    </div>
@endsection