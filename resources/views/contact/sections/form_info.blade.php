<!-- Header Banner Section -->
<section class="relative py-16 sm:py-24 bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('{{ asset('images/bg_hubungi_kami.png') }}');">
    <!-- Overlay Hitam Transparan -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header Title -->
        <div class="text-center max-w-3xl mx-auto space-y-6 contact-header">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                Hubungi KUBE YPAC
            </h1>
            <p class="text-base sm:text-lg text-gray-100 leading-relaxed">
                Kami selalu senang mendengar dari Anda! Baik untuk pertanyaan seputar E-Katalog, pesanan suvenir dalam
                jumlah besar (bulk order), maupun peluang kemitraan. Setiap dukungan Anda berarti besar bagi kemandirian
                siswa YPAC.
            </p>
        </div>
    </div>
</section>

<!-- Main Contact Content Section -->
<section class="py-16 sm:py-24 bg-white relative overflow-hidden">
    <!-- Floating decorative backgrounds for premium UI look -->
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-50 rounded-full filter blur-3xl opacity-60 z-0"></div>
    <div class="absolute bottom-10 right-0 w-96 h-96 bg-pink-50 rounded-full filter blur-3xl opacity-50 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Content Grid: Info on Left, Form Card on Right -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            <!-- Info Column (Left) -->
            <div class="lg:col-span-5 space-y-8 contact-info-column">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Mari Terhubung & Berkolaborasi!
                </h2>

                <!-- Contact Details List -->
                <div class="space-y-6">
                    <!-- Telepon -->
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-50 text-[#0073E2] flex items-center justify-center flex-shrink-0 mt-1 shadow-inner">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Telepon</p>
                            <a href="https://wa.me/6285373479852" target="_blank" rel="noopener noreferrer"
                                class="text-base sm:text-lg font-bold text-gray-700 hover:text-[#0073E2] transition-colors mt-0.5 block">
                                +62 853-7347-9852
                            </a>
                            <p class="text-xs text-gray-400 font-semibold mt-0.5">WhatsApp Admin</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-pink-50 text-[#e23cbf] flex items-center justify-center flex-shrink-0 mt-1 shadow-inner">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Email</p>
                            <a href="mailto:ypacsemarang.ofc@gmail.com"
                                class="text-base sm:text-lg font-bold text-gray-700 hover:text-[#e23cbf] transition-colors mt-0.5 block">
                                ypacsemarang.ofc@gmail.com
                            </a>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-orange-50 text-[#f97316] flex items-center justify-center flex-shrink-0 mt-1 shadow-inner">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-550 leading-relaxed mt-0.5">
                                Jl. Kh Ahmad Dahlan No.4, Pekunden, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah
                                50134
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card Column (Right) -->
            <div class="lg:col-span-7 contact-form-column">
                <div class="bg-white border border-gray-100 rounded-[2rem] p-8 sm:p-10 shadow-2xl relative">
                    <div class="mb-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">
                            Mari Terhubung & Berkolaborasi!
                        </h3>
                        <p class="text-gray-400 text-sm mt-1 leading-relaxed">
                            Silakan isi formulir di bawah ini. Tim kami akan segera membalas pesan Anda di jam
                            operasional.
                        </p>
                    </div>

                    <!-- Success Alert Message -->
                    @if(session('success'))
                        <div
                            class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-800 text-sm flex items-start gap-3">
                            <i data-lucide="check-circle" class="w-5 h-6 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-extrabold text-green-900">Berhasil!</p>
                                <p class="mt-0.5 font-semibold text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Error Alert Message -->
                    @if(session('error'))
                        <div
                            class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-sm flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-extrabold text-red-900">Gagal!</p>
                                <p class="mt-0.5 font-semibold text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Contact Form -->
                    <form action="{{ route('home.contact.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="space-y-2">
                            <label for="contact-name" class="text-xs sm:text-sm font-bold text-gray-700">Nama
                                Lengkap</label>
                            <input type="text" id="contact-name" name="name" required placeholder="Cth: Budi Santoso"
                                class="w-full px-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-250 rounded-2xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="contact-info" class="text-xs sm:text-sm font-bold text-gray-700">Email</label>
                            <input type="email" id="contact-info" name="contact_info" required
                                placeholder="Cth: budi@gmail.com"
                                class="w-full px-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-250 rounded-2xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                        </div>

                        <!-- Pilih Topik Select -->
                        <div class="space-y-2">
                            <label for="contact-topic" class="text-xs sm:text-sm font-bold text-gray-700">Pilih
                                Topik</label>
                            <div class="relative">
                                <select id="contact-topic" name="topic" required onchange="updateSelectColor()"
                                    class="w-full px-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-255 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-400 appearance-none cursor-pointer">
                                    <option value="" disabled selected class="text-gray-400 bg-white">Pilih Topik Kerja
                                        Sama...</option>
                                    <option value="Kerja Sama Instansi" class="text-gray-800 bg-white font-semibold">
                                        Kerja Sama Instansi</option>
                                    <option value="Donasi" class="text-gray-800 bg-white font-semibold">Donasi</option>
                                    <option value="Magang" class="text-gray-800 bg-white font-semibold">Magang</option>
                                    <option value="Pesanan Jumlah Besar" class="text-gray-800 bg-white font-semibold">
                                        Pesanan Jumlah Besar (Bulk Order)</option>
                                    <option value="Pertanyaan Umum" class="text-gray-800 bg-white font-semibold">
                                        Pertanyaan Umum / E-Katalog</option>
                                </select>
                                <span
                                    class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Pesan Anda -->
                        <div class="space-y-2">
                            <label for="contact-message" class="text-xs sm:text-sm font-bold text-gray-700">Pesan
                                anda</label>
                            <textarea id="contact-message" name="message" required
                                placeholder="Tulis pesan Anda di sini..." rows="4"
                                class="w-full px-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-250 rounded-2xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800 h-32 resize-none"></textarea>
                        </div>

                        <!-- Kirim Pesan Button -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-100 hover:shadow-xl transition-all duration-200 cursor-pointer text-center text-sm sm:text-base">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>