<!-- Section 4: Visi, Misi & Tujuan (with Metrik blocks) -->
<section class="py-16 sm:py-24 bg-white relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 vision-tabs-container">
        <!-- Tabs Controls -->
        <div class="flex justify-center items-center gap-3 sm:gap-4 mb-8 sm:mb-10">
            <button onclick="switchTab('visi')" id="tab-btn-visi" 
                class="px-6 py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 border cursor-pointer bg-[#0073E2] text-white border-transparent shadow-md shadow-blue-100">
                Visi
            </button>
            <button onclick="switchTab('misi')" id="tab-btn-misi" 
                class="px-6 py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 border cursor-pointer bg-gray-100 text-gray-600 border-transparent hover:bg-gray-200 hover:text-gray-800">
                Misi
            </button>
            <button onclick="switchTab('tujuan')" id="tab-btn-tujuan" 
                class="px-6 py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 border cursor-pointer bg-gray-100 text-gray-600 border-transparent hover:bg-gray-200 hover:text-gray-800">
                Tujuan
            </button>
        </div>

        <!-- Tab Content Cards -->
        <div class="relative min-h-[220px]">
            <!-- Visi Card -->
            <div id="tab-content-visi" class="tab-pane bg-[#0073E2] text-white p-8 sm:p-12 rounded-[2rem] shadow-xl transition-all duration-300 scale-100 opacity-100 block">
                <h3 class="text-2xl sm:text-3xl font-extrabold mb-4">Visi Kami</h3>
                <p class="text-base sm:text-lg text-blue-50 leading-relaxed font-semibold">
                    Mencegah secara dini dan membina anak penyandang disabilitas agar menjadi generasi penerus yang berkualitas, inklusif, dan mandiri.
                </p>
            </div>

            <!-- Misi Card -->
            <div id="tab-content-misi" class="tab-pane bg-[#e23cbf] text-white p-8 sm:p-12 rounded-[2rem] shadow-xl transition-all duration-300 scale-95 opacity-0 hidden">
                <h3 class="text-2xl sm:text-3xl font-extrabold mb-6">Misi Utama</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-4">
                        <span class="w-8 h-8 rounded-lg bg-white text-[#e23cbf] font-extrabold text-sm flex items-center justify-center flex-shrink-0 mt-0.5">01</span>
                        <span class="text-base sm:text-lg font-semibold leading-relaxed">Memberikan pelayanan habilitasi dan rehabilitasi yang terpadu.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="w-8 h-8 rounded-lg bg-white text-[#e23cbf] font-extrabold text-sm flex items-center justify-center flex-shrink-0 mt-0.5">02</span>
                        <span class="text-base sm:text-lg font-semibold leading-relaxed">Mengembangkan potensi siswa menuju kemandirian ekonomi melalui karya nyata.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="w-8 h-8 rounded-lg bg-white text-[#e23cbf] font-extrabold text-sm flex items-center justify-center flex-shrink-0 mt-0.5">03</span>
                        <span class="text-base sm:text-lg font-semibold leading-relaxed">Memperjuangkan kesamaan hak agar mencapai kesejahteraan yang sempurna.</span>
                    </li>
                </ul>
            </div>

            <!-- Tujuan Card -->
            <div id="tab-content-tujuan" class="tab-pane bg-[#f97316] text-white p-8 sm:p-12 rounded-[2rem] shadow-xl transition-all duration-300 scale-95 opacity-0 hidden">
                <h3 class="text-2xl sm:text-3xl font-extrabold mb-4">Tujuan Program</h3>
                <p class="text-base sm:text-lg text-orange-50 leading-relaxed font-semibold">
                    Menyediakan wadah bagi siswa YPAC untuk mempraktikkan keterampilan vokasional mereka dalam ekosistem ekonomi nyata, menciptakan rasa bangga melalui karya yang dihargai oleh masyarakat umum.
                </p>
            </div>
        </div>

        <!-- Achievement Metrics Grid with Hover Effects -->
        <div class="mt-12 space-y-6 stats-container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat 1: Tahun Berdiri -->
                <div class="flex flex-col items-center justify-center p-8 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm cursor-default transition-colors duration-300 group hover:bg-[#0073E2] stat-box">
                    <span class="text-3xl sm:text-4xl font-extrabold text-[#0073E2] transition-colors duration-300 group-hover:text-white stat-counter-year">1953</span>
                    <span class="text-sm font-semibold text-gray-500 mt-2 transition-colors duration-300 group-hover:text-blue-100">Tahun Berdiri</span>
                </div>

                <!-- Stat 2: Cabang Nasional -->
                <div class="flex flex-col items-center justify-center p-8 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm cursor-default transition-colors duration-300 group hover:bg-[#e23cbf] stat-box">
                    <span class="text-3xl sm:text-4xl font-extrabold text-[#e23cbf] transition-colors duration-300 group-hover:text-white stat-counter-branches">16</span>
                    <span class="text-sm font-semibold text-gray-500 mt-2 transition-colors duration-300 group-hover:text-pink-100">Cabang Nasional</span>
                </div>
            </div>

            <!-- Stat 3: Karya Tercipta -->
            <div class="flex flex-col items-center justify-center p-8 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm cursor-default transition-colors duration-300 group hover:bg-[#f97316] stat-box">
                <span class="text-3xl sm:text-4xl font-extrabold text-[#f97316] transition-colors duration-300 group-hover:text-white">RIBUAN</span>
                <span class="text-sm font-semibold text-gray-500 mt-2 transition-colors duration-300 group-hover:text-orange-100">Karya Tercipta</span>
            </div>
        </div>
    </div>
</section>
