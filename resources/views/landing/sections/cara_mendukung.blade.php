<!-- Cara Mendukung Section -->
<section class="relative py-20 lg:py-28 bg-cover bg-center bg-no-repeat overflow-hidden"
    style="background-image: url('{{ asset('images/bg_cara_mendukung.png') }}');">
    <!-- Overlay Hitam Transparan -->
    <div class="absolute inset-0 bg-black/65 z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 support-header">
            <span class="text-sm font-bold uppercase tracking-wider text-blue-400">Kontribusi Anda</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mt-1">Cara Mendukung</h2>
            <p class="text-base text-gray-200 mt-4 leading-relaxed">
                Tiga langkah mudah untuk memberikan dampak nyata bagi pemberdayaan kreativitas dan kemandirian siswa
                disabilitas.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 support-grid">
            <!-- Card 1 -->
            <div
                class="bg-white border border-gray-100 rounded-3xl p-8 hover:bg-[#0073E2] hover:border-[#0073E2] hover:shadow-xl hover:shadow-blue-100 transition-[background-color,border-color,box-shadow] duration-300 group flex flex-col justify-between support-card-item">
                <div class="space-y-6">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-50 text-[#0073E2] group-hover:bg-white group-hover:text-[#0073E2] flex items-center justify-center transition-all duration-300">
                        <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                    </div>
                    <h3
                        class="text-xl font-extrabold text-gray-900 group-hover:text-white transition-colors duration-300">
                        Beli Produk</h3>
                    <p
                        class="text-sm text-gray-550 leading-relaxed group-hover:text-blue-50 transition-colors duration-300">
                        Pilih dan beli hasil karya unik mereka. Setiap rupiah sangat berarti.
                    </p>
                </div>
                <div class="pt-8">
                    <a href="{{ route('home.products') }}"
                        class="inline-flex items-center gap-1.5 text-sm font-bold text-[#0073E2] group-hover:text-white group-hover:translate-x-1 transition-all duration-300">
                        <span>Lihat Katalog</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white border border-gray-100 rounded-3xl p-8 hover:bg-[#e23cbf] hover:border-[#e23cbf] hover:shadow-xl hover:shadow-pink-100 transition-[background-color,border-color,box-shadow] duration-300 group flex flex-col justify-between support-card-item">
                <div class="space-y-6">
                    <div
                        class="w-12 h-12 rounded-full bg-pink-50 text-[#e23cbf] group-hover:bg-white group-hover:text-[#e23cbf] flex items-center justify-center transition-all duration-300">
                        <i data-lucide="share-2" class="w-6 h-6"></i>
                    </div>
                    <h3
                        class="text-xl font-extrabold text-gray-900 group-hover:text-white transition-colors duration-300">
                        Bagikan Cerita</h3>
                    <p
                        class="text-sm text-gray-550 leading-relaxed group-hover:text-pink-50 transition-colors duration-300">
                        Bantu kami menjangkau lebih banyak orang dengan membagikan kampanye kami di media sosial.
                    </p>
                </div>
                <div class="pt-8">
                    <button onclick="sharePage()"
                        class="inline-flex items-center gap-1.5 text-sm font-bold text-[#e23cbf] group-hover:text-white group-hover:translate-x-1 transition-all duration-300 cursor-pointer">
                        <span>Bagikan Cerita</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white border border-gray-100 rounded-3xl p-8 hover:bg-[#f97316] hover:border-[#f97316] hover:shadow-xl hover:shadow-orange-100 transition-[background-color,border-color,box-shadow] duration-300 group flex flex-col justify-between support-card-item">
                <div class="space-y-6">
                    <div
                        class="w-12 h-12 rounded-full bg-orange-50 text-[#f97316] group-hover:bg-white group-hover:text-[#f97316] flex items-center justify-center transition-all duration-300">
                        <i data-lucide="handshake" class="w-6 h-6"></i>
                    </div>
                    <h3
                        class="text-xl font-extrabold text-gray-900 group-hover:text-white transition-colors duration-300">
                        Mitra Kerjasama</h3>
                    <p
                        class="text-sm text-gray-500 leading-relaxed group-hover:text-orange-50 transition-colors duration-300">
                        Jadilah mitra strategis dalam mengembangkan program pembinaan dan distribusi produk.
                    </p>
                </div>
                <div class="pt-8">
                    <a href="{{ route('home.contact', ['topik' => 'instansi']) }}"
                        class="inline-flex items-center gap-1.5 text-sm font-bold text-orange-600 group-hover:text-white group-hover:translate-x-1 transition-all duration-300">
                        <span>Mitra Kerjasama</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>