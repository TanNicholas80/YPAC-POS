<!-- Lebih dari Sekedar Belanja CTA Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#0073E2] rounded-[2.5rem] shadow-xl overflow-hidden relative p-8 sm:p-12 lg:p-16 group">
            <!-- Background decor circles -->
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full z-0"></div>
            <div class="absolute bottom-[-100px] left-[20%] w-[400px] h-[400px] bg-white/5 rounded-full z-0"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <!-- Text -->
                <div class="lg:col-span-8 space-y-6 text-center lg:text-left text-white">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                        Lebih dari Sekedar Belanja
                    </h2>
                    <p class="text-blue-100 text-base sm:text-lg max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Temukan kisah inspiratif di balik setiap jahitan dan ukiran. Mari bersama merajut masa depan
                        yang lebih inklusif.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('home.products') }}"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-blue-50 text-[#0073E2] font-bold rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                            <span>Lihat Koleksi Produk</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Side visual circle -->
                <div class="lg:col-span-4 flex justify-center">
                    <div
                        class="w-48 h-48 sm:w-60 sm:h-60 rounded-full bg-white/10 border-8 border-white/20 shadow-inner flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/2G5A2426.JPG') }}" alt="Visual Kreasi Anak"
                            class="object-cover w-full h-full transform group-hover:scale-110 transition-transform duration-500" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>