@extends('layouts.guest')

@section('content')
    <!-- Hero Section Component -->
    @include('landing.sections.hero')

    <!-- Keunggulan Section Component -->
    @include('landing.sections.keunggulan')

    <!-- Tentang Kami Detail Component (Links to /tentang-kami) -->
    @include('landing.sections.about')

    <!-- Produk Unggulan Component -->
    @include('landing.sections.featured_products')

    <!-- Cara Mendukung Component -->
    @include('landing.sections.cara_mendukung')

    <!-- Panduan Cara Pemesanan Component -->
    @include('landing.sections.panduan_pemesanan')

    <!-- Testimoni Pembeli Component -->
    @include('landing.sections.testimonials')

    <!-- Kenali Para Pembuatnya Component -->
    @include('landing.sections.creators')

    <!-- Lebih Dari Sekedar Belanja Component -->
    @include('landing.sections.cta')
@endsection