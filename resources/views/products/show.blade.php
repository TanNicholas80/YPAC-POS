@extends('layouts.app')

@section('title', 'Preview Produk - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 overflow-y-auto bg-[#F5F8FC]">
    
    <!-- Back Header -->
    <div class="flex items-center gap-4 mb-6 shrink-0">
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-[#0073E2] hover:text-blue-600 transition-colors font-bold text-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            <span>Kembali ke Manajemen Produk</span>
        </a>
    </div>

    <!-- Title Header -->
    <div class="max-w-4xl w-full mx-auto mb-6 shrink-0">
        <h1 class="text-2xl font-bold text-gray-900 leading-tight">Preview Detail Produk</h1>
        <p class="text-xs text-gray-500 font-medium">Tampilan pratinjau detail produk di sisi pelanggan.</p>
    </div>

    <!-- Main Detail Component -->
    <div class="max-w-4xl w-full mx-auto">
        @include('products.partials.detail_content', ['product' => $product, 'isAdmin' => true])
    </div>

</div>
@endsection
