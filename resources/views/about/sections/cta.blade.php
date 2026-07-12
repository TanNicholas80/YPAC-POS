<!-- Section 6: CTA Section -->
<section class="py-16 sm:py-24 bg-white relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-[#0073E2] rounded-[2.5rem] p-8 sm:p-12 md:p-16 text-center text-white space-y-8 shadow-xl shadow-blue-200 relative overflow-hidden">
            <!-- Background accents -->
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-[-100px] right-[-100px] w-64 h-64 bg-white/10 rounded-full"></div>

            <div class="relative z-10 space-y-6">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Jadilah Bagian dari Perjalanan Mereka
                </h2>
                <p class="text-sm sm:text-base text-blue-100 max-w-2xl mx-auto leading-relaxed">
                    Dukungan Anda memberikan dampak langsung bagi kelangsungan program pembinaan dan pendidikan siswa YPAC.
                </p>
                
                <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('home.products') }}" 
                        class="px-8 py-4 bg-white hover:bg-blue-50 text-[#0073E2] font-bold rounded-2xl shadow-lg transition-all duration-200 cursor-pointer active:scale-95 text-center w-full sm:w-auto">
                        Mulai Belanja Sekarang
                    </a>
                    <a href="{{ route('home.contact', ['topik' => 'instansi']) }}"
                        class="px-8 py-4 bg-transparent border-2 border-white hover:bg-white/10 text-white font-bold rounded-2xl transition-all duration-200 cursor-pointer active:scale-95 text-center w-full sm:w-auto">
                        Hubungi Kemitraan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
