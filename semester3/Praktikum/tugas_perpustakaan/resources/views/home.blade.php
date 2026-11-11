<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan Digital - Nwpiss</title>

        <!-- Fonts & Vite Assets -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex flex-col justify-between">

        <!-- Navigation Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <!-- Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-gray-900 text-lg">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span>Perpustakaan Nwpiss</span>
                </a>

                <!-- Nav Links -->
                <nav class="flex items-center gap-3">
                    @auth
                        @can('lihat daftar buku')
                            <a href="{{ route('buku.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md">
                                Daftar Buku
                            </a>
                        @endcan

                        @role('Admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 px-3 py-2 bg-blue-50 rounded-md">
                                Dashboard Admin
                            </a>
                        @endrole

                        @role('Petugas')
                            <a href="{{ route('petugas.dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 px-3 py-2 bg-blue-50 rounded-md">
                                Dashboard Petugas
                            </a>
                        @endrole

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 text-gray-400 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 01-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">Profil Saya</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Logout</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-4 py-2">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md shadow-sm transition">
                            Register
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Main Content Layout -->
        <main class="flex-grow">
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Hero Content -->
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-3">
                            Sistem Informasi Perpustakaan Digital
                        </p>
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight leading-tight mb-4">
                            Layanan Perpustakaan & Manajemen Koleksi Buku
                        </h1>
                        <p class="text-base text-gray-600 mb-8 leading-relaxed">
                            Platform pengelolaan data peminjaman buku, katalog koleksi, dan hak akses pengguna berbasis Role-Based Access Control (RBAC).
                        </p>

                        <div class="flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('buku.index') }}" class="px-5 py-2.5 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-sm transition">
                                    Lihat Koleksi Buku
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-sm transition">
                                    Masuk ke Sistem
                                </a>
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-md bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium text-sm shadow-sm transition">
                                    Daftar Akun Siswa
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Status Card -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200 shadow-sm space-y-4">
                        <h2 class="text-base font-semibold text-gray-900 pb-3 border-b border-gray-100">
                            Pembagian Hak Akses Sistem
                        </h2>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 flex items-center justify-center shrink-0 font-medium text-xs">
                                01
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Admin</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Pengelolaan seluruh data perpustakaan, akun pengguna, penetapan role, dan laporan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 flex items-center justify-center shrink-0 font-medium text-xs">
                                02
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Petugas</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Pengelolaan data buku serta pemrosesan transaksi peminjaman dan pengembalian.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 flex items-center justify-center shrink-0 font-medium text-xs">
                                03
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Siswa</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Akses katalog buku, pengelolaan profil mandiri, dan peninjauan riwayat peminjaman.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6">
            <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Perpustakaan Digital Nwpiss. All rights reserved.
            </div>
        </footer>
    </body>
</html>