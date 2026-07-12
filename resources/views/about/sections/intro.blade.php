<!-- Section 1: Header / Intro & Section 2: Quote & Philosophy Grid -->
<section class="py-16 sm:py-24 bg-white relative overflow-hidden">
    <!-- Floating decorative backgrounds for premium UI look -->
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-50 rounded-full filter blur-3xl opacity-60 z-0"></div>
    <div class="absolute bottom-10 right-0 w-96 h-96 bg-pink-50 rounded-full filter blur-3xl opacity-50 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section 1: Header / Intro -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 space-y-6">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-[#0073E2] tracking-tight">
                Tentang Kami
            </h1>
            <p class="text-base sm:text-lg text-gray-550 leading-relaxed">
                Kelompok Usaha Bersama (KUBE) YPAC Jakarta dibentuk untuk memberikan pelatihan kerja nyata kepada
                siswa-siswi disabilitas agar mereka memiliki keahlian hidup mandiri. Melalui program ini, mereka belajar
                menghasilkan kerajinan bernilai jual serta makanan & minuman higienis.
            </p>
        </div>

        <!-- Section 2: Quote & Philosophy Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <!-- Image Column (Left) -->
            <div class="lg:col-span-5 relative">
                <div
                    class="absolute -inset-4 rounded-[2.5rem] bg-gradient-to-tr from-blue-100 to-pink-100 opacity-30 blur-lg -z-10">
                </div>
                <div
                    class="overflow-hidden rounded-[2rem] border border-gray-100 shadow-2xl bg-white aspect-[4/3] sm:aspect-square lg:aspect-[4/5] xl:aspect-square">
                    <img src="{{ asset('images/2G5A2489.JPG') }}" alt="Gedung Pusat Rehabilitasi YPAC"
                        class="object-cover w-full h-full transform hover:scale-102 transition-transform duration-500">
                </div>
            </div>

            <!-- Text & Quote Column (Right) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Large Quote Icon -->
                <div class="text-6xl sm:text-7xl font-serif text-[#0073E2] leading-none select-none -mb-4">
                    “
                </div>

                <!-- Highlighted Quote Text -->
                <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-snug tracking-tight">
                    Beri anak ikan dan dia akan makan hari itu. Berilah anak itu <span class="text-[#0073E2]">sebuah
                        kail</span>, lalu ajarilah mengail, maka ia akan makan untuk seumur hidupnya.
                </h3>

                <!-- Descriptive Paragraphs -->
                <div class="space-y-4 text-gray-600 text-sm sm:text-base leading-relaxed">
                    <p>
                        Seringkali bantuan sosial hanya bersifat konsumtif sementara. Di YPAC, kami bergerak lebih jauh
                        dari sekadar pemberian 'ikan' untuk memastikan masa depan yang berkelanjutan.
                    </p>
                    <p>
                        E-Katalog ini adalah 'kail' tersebut. Setiap produk yang Anda beli adalah hasil dari
                        keterampilan nyata (Pre-vocational Training) yang membekali mereka untuk kemandirian seumur
                        hidup.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
