<!-- Tentang Kami Section -->
<section id="tentang-kami" class="py-20 lg:py-28 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Image Column -->
            <div class="relative order-last lg:order-first">
                <div
                    class="relative overflow-hidden rounded-[2rem] border border-gray-100 shadow-xl bg-white aspect-square">
                    <img src="{{ asset('images/2G5A2411.JPG') }}" alt="Tentang Kami KUBE YPAC"
                        class="object-cover w-full h-full" loading="lazy">
                </div>
                <div
                    class="absolute -bottom-6 -right-4 bg-[#e23cbf] text-white p-6 rounded-3xl shadow-xl max-w-[260px]">
                    <p class="text-3xl font-extrabold">100%</p>
                    <p class="text-sm font-medium mt-1 leading-relaxed">Keuntungan disalurkan untuk pembinaan kemandirian siswa</p>
                </div>
            </div>

            <!-- Text Column -->
            <div class="space-y-6">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    Mewujudkan Kemandirian <br class="hidden sm:inline">
                    <span class="text-[#e23cbf]">Melalui Pemberdayaan Kreatif</span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                    Setiap produk yang Anda beli di toko ini bukan hanya sekedar transaksi belanja, melainkan wujud
                    nyata dukungan Anda atas kemandirian, rasa percaya diri, dan apresiasi karya hebat anak bangsa.
                </p>
                <div class="pt-4">
                    <a href="{{ route('home.about') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-[#F8FAFC] hover:bg-[#e23cbf] hover:text-white hover:border-[#e23cbf] hover:shadow-md text-gray-900 font-semibold rounded-full border border-gray-200 transition-all duration-200">
                        <span>Tentang Kami</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 transition-colors"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>