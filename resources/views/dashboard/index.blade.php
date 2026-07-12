@extends('layouts.app')

@section('title', 'Dashboard - SIKAS YPAC')

@section('content')
    <div class="flex-1 flex flex-col items-center justify-center p-8 md:p-12">
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