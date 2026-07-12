@extends('layouts.guest')

@section('title', $product->product_name . ' - KUBE YPAC')

@section('content')
    <!-- Product Main Detail Section -->
    <section class="py-12 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-bold text-gray-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-[#0073E2]">Beranda</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                <a href="{{ route('home.products') }}" class="hover:text-[#0073E2]">Produk</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                <span class="text-gray-600 font-extrabold">{{ $product->product_name }}</span>
            </div>

            <!-- Main Product Component -->
            @include('products.partials.detail_content', ['product' => $product, 'isAdmin' => false])

            <!-- Section: Temukan Produk Lainnya -->
            @if($relatedProducts->count() > 0)
                <div class="mt-20 space-y-8">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                            Temukan Produk Lainnya
                        </h2>
                        <a href="{{ route('home.products') }}" class="text-sm font-bold text-[#0073E2] hover:text-blue-600 transition-colors flex items-center gap-1">
                            Lihat produk <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <!-- Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($relatedProducts as $related)
                            @php
                                $rFirstImage = $related->images->first();
                                $rImageSrc = $rFirstImage ? (str_starts_with($rFirstImage->image_path, 'http') ? $rFirstImage->image_path : asset($rFirstImage->image_path)) : asset('images/hero_handcrafts.png');
                            @endphp

                            <!-- Card Element -->
                            <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-xl hover:shadow-gray-200/40 hover:border-gray-250 transition-all duration-300 flex flex-col justify-between h-full">
                                <div>
                                    <!-- Image -->
                                    <div class="aspect-4/3 relative overflow-hidden bg-gray-50 border-b border-gray-100">
                                        <img src="{{ $rImageSrc }}" alt="{{ $related->product_name }}"
                                            class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500">
                                        <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-white text-[#0073E2] shadow-sm border border-gray-100">
                                            {{ $related->category->category_name ?? 'Produk' }}
                                        </span>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6 space-y-2">
                                        <h3 class="font-extrabold text-gray-900 text-lg leading-snug group-hover:text-[#0073E2] transition-colors line-clamp-1">
                                            {{ $related->product_name }}
                                        </h3>
                                        <p class="text-xs text-gray-500 font-medium line-clamp-2">
                                            {{ $related->description ?? 'Karya berkualitas hasil kerajinan dan kreasi siswa KUBE YPAC.' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="p-6 pt-0 space-y-4">
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-xs font-bold text-gray-400">Harga ({{ $related->unit->unit_name ?? 'pcs' }})</span>
                                        <span class="text-xl font-extrabold text-[#0073E2]">
                                            Rp {{ number_format($related->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex gap-2.5">
                                        <a href="{{ route('home.product.detail', $related->product_slug) }}" 
                                            class="flex-1 py-3 bg-gray-50 hover:bg-gray-150 border border-gray-200 text-gray-700 font-bold rounded-2xl transition-all duration-200 flex items-center justify-center gap-2 text-sm text-center">
                                            <i data-lucide="eye" class="w-4 h-4 text-gray-500"></i>
                                            <span>Detail</span>
                                        </a>
                                        <button onclick="addToCart({{ $related->id }}, '{{ addslashes($related->product_name) }}', {{ $related->price }}, '{{ $rImageSrc }}')"
                                            class="flex-1 py-3 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl shadow-md shadow-blue-100 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm cursor-pointer">
                                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                            <span>+ Keranjang</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection
