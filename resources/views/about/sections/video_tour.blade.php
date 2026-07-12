<!-- Section 5: Video (Virtual Tour) -->
<section class="py-16 sm:py-24 bg-[#F8FAFC] border-t border-b border-gray-100 relative overflow-hidden">
    <!-- Floating decorative backgrounds -->
    <div class="absolute -top-24 right-0 w-80 h-80 bg-blue-50/50 rounded-full filter blur-3xl opacity-60 z-0"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
            Kunjungi Ruang Karya KUBE YPAC
        </h2>
        <p class="text-base sm:text-lg text-gray-550 mt-4 max-w-2xl mx-auto leading-relaxed">
            Intip lebih dekat fasilitas dan ruang praktik KUBE YPAC melalui tur virtual singkat ini.
        </p>

        <!-- Video Player Card -->
        <div class="mt-8 sm:mt-12 relative rounded-[2rem] overflow-hidden border border-gray-200/60 shadow-2xl bg-black aspect-[16/10] sm:aspect-video group">
            <!-- Video Tag -->
            <video id="virtual-tour-video" class="w-full h-full object-cover" muted playsinline loop>
                <source src="{{ asset('images/YPACSchoolTour.mp4') }}" type="video/mp4">
                Browser Anda tidak mendukung tag video.
            </video>
            
            <!-- Custom Play Button Overlay -->
            <div id="video-overlay" onclick="togglePlay()" class="absolute inset-0 flex flex-col items-center justify-center bg-black/40 text-white gap-3 cursor-pointer transition-all duration-300 z-10 group-hover:bg-black/50">
                <div class="w-16 h-16 rounded-full border-4 border-white flex items-center justify-center bg-white/20 hover:scale-110 hover:bg-white/30 transition-all duration-300">
                    <i data-lucide="play" class="w-8 h-8 fill-white text-white translate-x-0.5"></i>
                </div>
                <span class="text-base sm:text-lg font-bold tracking-wide">Putar Video</span>
            </div>
        </div>
    </div>
</section>
