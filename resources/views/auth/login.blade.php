<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F5F8FC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIKAS YPAC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LogoYPAC.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-4 relative"
    style="background-image: url('{{ asset('images/login.jpg') }}');">
    <!-- Overlay Putih Transparan -->
    <div class="absolute inset-0 bg-white/65 z-0"></div>

    <div
        class="relative z-10 w-full max-w-md bg-white/95 rounded-3xl shadow-2xl border border-white/50 p-8 md:p-10 flex flex-col items-center">
        <!-- Logo / App Icon -->
        <div
            class="w-16 h-16 rounded-2xl bg-[#0073E2] flex items-center justify-center text-white mb-6 shadow-md shadow-blue-200">
            <i data-lucide="calculator" class="w-8 h-8"></i>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-1 tracking-tight text-center">SIKAS YPAC</h1>
        <p class="text-sm text-gray-500 mb-8 text-center font-medium">Sistem Kasir YPAC Inklusif</p>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div
                class="w-full mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="w-full space-y-6">
            @csrf

            <!-- Username Field -->
            <div class="space-y-2">
                <label for="username" class="text-sm font-semibold text-gray-700">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                        placeholder="Masukkan username"
                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-medium">
                </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </span>
                    <input type="password" name="password" id="password" required placeholder="Masukkan password"
                        class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-medium">
                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                        <i id="password-toggle-icon" data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 text-base">
                <span>Masuk Sistem</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </button>
        </form>

        <!-- Footnote -->
        <p class="mt-8 text-xs text-gray-400 text-center leading-relaxed max-w-[280px]">
            Akses terbatas untuk pengurus terdaftar. Hubungi administrator jika mengalami kendala.
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                toggleIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>

</html>