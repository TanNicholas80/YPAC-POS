<!-- Section 3: Pendiri (Founder) -->
<section class="py-16 sm:py-24 bg-[#F8FAFC] border-y border-gray-100 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-100/40 rounded-full filter blur-3xl z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <!-- Text Column (Left) -->
            <div class="lg:col-span-7 space-y-6">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    Berawal dari Sebuah Dedikasi
                </h2>
                <div class="space-y-4 text-gray-600 text-sm sm:text-base leading-relaxed">
                    <p>
                        Yayasan Pembinaan Anak Cacat (YPAC) didirikan pada tahun 1953 oleh <strong class="text-gray-900 font-extrabold">Prof. Dr. Soeharso</strong>, ahli bedah tulang pertama yang merintis rehabilitasi di Indonesia.
                    </p>
                    <p>
                        Kini, nilai tersebut hidup melalui Kelompok Usaha Bersama (KUBE). Pembinaan tidak berhenti pada terapi fisik, melainkan berlanjut pada karya bernilai ekonomi.
                    </p>
                </div>
                <!-- Thick border Quote block -->
                <div class="p-5 bg-blue-50/70 border-l-4 border-[#0073E2] rounded-r-2xl">
                    <p class="text-[#0073E2] font-bold text-base italic leading-relaxed">
                        "Cacat atau tidak, bukanlah ukuran kemampuan seseorang."
                    </p>
                </div>
            </div>

            <!-- Image Column (Right) -->
            <div class="lg:col-span-5 relative flex justify-center lg:justify-end pr-6 pb-6 sm:pr-8 sm:pb-8">
                <div class="relative w-full max-w-sm lg:max-w-none">
                    <!-- Backdrop visual blur -->
                    <div class="absolute -inset-4 rounded-[2.5rem] bg-gradient-to-tr from-blue-150 to-blue-50 opacity-20 blur-lg -z-10"></div>
                    <!-- Profile Image -->
                    <div class="overflow-hidden rounded-[2.5rem] border border-gray-200/50 shadow-2xl bg-white aspect-[4/5] sm:aspect-square lg:aspect-[4/5] xl:aspect-square">
                        <img src="{{ asset('images/prof_soeharso.png') }}" alt="Prof. Dr. Soeharso" 
                            class="object-cover w-full h-full transform hover:scale-102 transition-transform duration-500" loading="lazy">
                    </div>
                    <!-- Overlay Badge card outside the overflow-hidden container to allow offset overflow -->
                    <div class="absolute -bottom-6 -right-6 sm:-right-8 bg-[#0073E2] text-white px-8 py-5 rounded-[1.5rem] shadow-2xl shadow-blue-200/50 max-w-[260px] z-20">
                        <p class="text-xs font-semibold text-blue-100/90 tracking-wide">Pendiri YPAC</p>
                        <p class="text-lg sm:text-xl font-extrabold mt-1 tracking-tight">Prof. Dr. Soeharso</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
