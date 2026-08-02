@extends('layouts.app')

@section('title', 'Edit Profil - SIKAS YPAC')

@section('content')
<div class="p-6 md:p-10 max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Edit Profil</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan kata sandi akun Anda.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-600"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert General Errors -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 space-y-1">
            <div class="flex items-center gap-2 font-semibold text-sm">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 text-red-600"></i>
                <span>Terdapat kesalahan pada pengisian form:</span>
            </div>
            <ul class="list-disc list-inside text-xs pl-7 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Profile -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Pengguna Header -->
            <div class="pb-4 border-b border-gray-100 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-[#0073E2] text-white flex items-center justify-center font-bold text-2xl shadow-md">
                    {{ substr($user->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">{{ $user->name }}</h2>
                    <p class="text-xs text-gray-500 font-medium">@ {{ $user->username }}</p>
                </div>
            </div>

            <!-- Field Nama & Username -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#0073E2] focus:ring-2 focus:ring-blue-100 transition-all text-sm @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="at-sign" class="w-5 h-5"></i>
                        </div>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#0073E2] focus:ring-2 focus:ring-blue-100 transition-all text-sm @error('username') border-red-500 @enderror"
                            placeholder="Masukkan username">
                    </div>
                    @error('username')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Section Ganti Password -->
            <div>
                <h3 class="font-bold text-gray-800 text-base mb-1">Ubah Password</h3>
                <p class="text-xs text-gray-500 mb-4">Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah password.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <input type="password" id="password" name="password"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#0073E2] focus:ring-2 focus:ring-blue-100 transition-all text-sm @error('password') border-red-500 @enderror"
                                placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="check-square" class="w-5 h-5"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#0073E2] focus:ring-2 focus:ring-blue-100 transition-all text-sm"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0073E2] hover:bg-blue-700 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
