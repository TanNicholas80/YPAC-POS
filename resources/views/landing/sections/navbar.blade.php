<!-- Header / Navbar -->
<header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <!-- Top Bar / Partner Logos -->
    <div class="border-b border-gray-100 py-3 bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center gap-6 sm:gap-8">
            <img src="{{ asset('images/LogoYPAC.png') }}" alt="Logo YPAC" class="h-8 sm:h-12 w-auto object-contain"
                loading="lazy">
            <img src="{{ asset('images/bimaxunkartur.jpeg') }}" alt="Logo Dikti Saintek"
                class="h-8 sm:h-12 w-auto object-contain" loading="lazy">
            <img src="{{ asset('images/unkartur_logo.png') }}" alt="Logo Universitas Karangturi"
                class="h-8 sm:h-12 w-auto object-contain" loading="lazy">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}"
                    class="text-2xl font-bold tracking-tight text-[#0073E2] flex items-center gap-2">
                    <img src="{{ asset('images/LogoYPAC.png') }}" alt="Logo YPAC" class="w-8 h-8 object-contain"
                        loading="lazy">
                    <span>KUBE YPAC</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('home') }}"
                    class="text-base font-semibold transition-all duration-200 border-b-2 pb-1 {{ Route::is('home') && !request()->is('*produk*') ? 'text-[#0073E2] border-[#0073E2]' : 'text-gray-600 border-transparent hover:text-[#0073E2] hover:border-[#0073E2]' }}">Beranda</a>
                <a href="{{ route('home.about') }}"
                    class="text-base font-semibold transition-all duration-200 border-b-2 pb-1 {{ Route::is('home.about') ? 'text-[#0073E2] border-[#0073E2]' : 'text-gray-600 border-transparent hover:text-[#0073E2] hover:border-[#0073E2]' }}">Tentang
                    Kami</a>
                <a href="{{ route('home.products') }}"
                    class="text-base font-semibold transition-all duration-200 border-b-2 pb-1 {{ request()->is('*produk*') || Route::is('home.products') ? 'text-[#0073E2] border-[#0073E2]' : 'text-gray-600 border-transparent hover:text-[#0073E2] hover:border-[#0073E2]' }}">Produk
                    Kami</a>
            </nav>

            <!-- Actions (Cart & Admin Portal) -->
            <div class="flex items-center gap-4">
                <!-- Shopping Cart Button -->
                <button onclick="toggleCart(true)"
                    class="relative p-2.5 text-gray-600 hover:text-[#0073E2] hover:bg-blue-50 rounded-xl transition-all duration-250 cursor-pointer"
                    aria-label="Buka Keranjang">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    <span id="cart-badge"
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white scale-0 transition-transform duration-200">0</span>
                </button>

                <!-- Kontak Kami Button -->
                <a href="{{ route('home.contact') }}"
                    class="hidden sm:flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#e23cbf] hover:bg-[#c92fa9] rounded-full shadow-sm hover:shadow transition-all duration-200">
                    <span>Kontak Kami</span>
                </a>

                <!-- Mobile Menu Toggle -->
                <button onclick="toggleMobileMenu()"
                    class="p-2 text-gray-600 hover:text-[#0073E2] md:hidden rounded-lg cursor-pointer">
                    <i data-lucide="menu" id="mobile-menu-icon" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-4 space-y-3 shadow-inner">
        <a href="{{ route('home') }}" onclick="toggleMobileMenu()"
            class="block text-base font-semibold text-gray-600 hover:text-[#0073E2] py-2">Beranda</a>
        <a href="{{ route('home.about') }}" onclick="toggleMobileMenu()"
            class="block text-base font-semibold py-2 {{ Route::is('home.about') ? 'text-[#0073E2]' : 'text-gray-600 hover:text-[#0073E2]' }}">Tentang
            Kami</a>
        <a href="{{ route('home.products') }}" onclick="toggleMobileMenu()"
            class="block text-base font-semibold text-gray-600 hover:text-[#0073E2] py-2">Produk Kami</a>
        <a href="{{ route('login') }}" class="flex items-center gap-2 text-base font-semibold text-[#0073E2] py-2">
            <i data-lucide="lock" class="w-4 h-4"></i>
            <span>Kasir Portal</span>
        </a>
        <div class="pt-2">
            <a href="{{ route('home.contact') }}" onclick="toggleMobileMenu()"
                class="flex items-center justify-center w-full px-6 py-2.5 text-sm font-semibold text-white bg-[#e23cbf] hover:bg-[#c92fa9] rounded-full shadow-sm transition-all duration-200">
                Kontak Kami
            </a>
        </div>
    </div>
</header>