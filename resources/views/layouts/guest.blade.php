<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KUBE YPAC - Produk Kreatif Karya Anak Disabilitas')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LogoYPAC.png') }}">
    <!-- Tailwind CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#F8FAFC] text-gray-800 antialiased overflow-x-hidden">

    <!-- Header / Navbar Component -->
    @include('landing.sections.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('landing.sections.footer')

    <!-- Slide-over Drawer & Cart Script Component -->
    @include('landing.sections.cart_drawer')



    @stack('scripts')
    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
    </script>
</body>

</html>
