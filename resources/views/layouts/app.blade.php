<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F5F8FC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIKAS YPAC - Sistem Kasir YPAC Inklusif')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LogoYPAC.png') }}">
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lucide Icons for premium visual feel -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body class="h-full flex text-gray-800 antialiased">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between flex-shrink-0">
        <!-- Sidebar Top -->
        <div>
            <!-- Profile/Brand Section -->
            <div class="p-6 flex items-center gap-3 border-b border-gray-50">
                <div
                    class="w-10 h-10 rounded-full bg-[#0073E2] flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <h2 class="font-bold text-gray-900 leading-tight">SIKAS YPAC</h2>
                    <span class="text-xs text-gray-500 font-medium">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </span>
                </div>
            </div>

            <!-- Menu Navigation -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('sales.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ Route::is('sales.*') ? 'bg-[#0073E2] text-white shadow-sm shadow-blue-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span>Sales</span>
                </a>

                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ Route::is('products.*') ? 'bg-[#0073E2] text-white shadow-sm shadow-blue-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="box" class="w-5 h-5"></i>
                    <span>Products</span>
                </a>

                <a href="{{ route('reports.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200 {{ Route::is('reports.*') ? 'bg-[#0073E2] text-white shadow-sm shadow-blue-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                    <span>Report</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom -->
        <div class="p-4 border-t border-gray-50 space-y-1">
            <!-- Form Logout -->
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span>Log Out</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Pane -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        @yield('content')
    </main>

    <!-- Lucide Icons initialization -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>