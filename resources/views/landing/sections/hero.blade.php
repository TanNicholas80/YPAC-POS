<!-- Hero Section (Beranda & Tentang Kami) -->
<section id="beranda" class="relative bg-white pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            <!-- Text Column -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.1]">
                    Produk Kreatif Karya <span class="text-[#0073E2]">Anak Disabilitas</span>
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Berdaya, Berkarya, Mandiri. Temukan keunikan produk kerajinan tangan lokal serta nikmati
                    hidangan lezat hasil kelompok usaha siswa-siswi di KUBE YPAC.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('home.products') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-200 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span>Belanja Sekarang</span>
                    </a>
                </div>
            </div>

            <!-- Graphic/Image Column -->
            <div class="lg:col-span-5 relative flex justify-center">
                <div class="relative w-full max-w-md lg:max-w-none">
                    <!-- Decorative background accents -->
                    <div
                        class="absolute -top-12 -left-12 w-64 h-64 bg-blue-100 rounded-full filter blur-3xl opacity-50 z-0">
                    </div>
                    <div
                        class="absolute -bottom-8 -right-8 w-64 h-64 bg-pink-100 rounded-full filter blur-3xl opacity-50 z-0">
                    </div>

                    <!-- Main Hero Image -->
                    <div
                        class="relative z-10 overflow-hidden rounded-3xl border border-gray-100 shadow-2xl shadow-gray-200 bg-gray-50 aspect-4/3 flex items-center justify-center">
                        <img src="{{ asset('images/2G5A2423.JPG') }}" alt="Produk Kerajinan KUBE YPAC"
                            class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>