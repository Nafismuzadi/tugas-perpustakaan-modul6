<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Beranda Perpustakaan</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col justify-between">
        
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('beranda') }}" class="flex items-center gap-2">
                                <div class="w-9 h-9 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                                    📚
                                </div>
                                <span class="font-bold text-xl text-gray-800 tracking-tight">PerpusDigital</span>
                            </a>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <a href="{{ route('beranda') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-semibold text-gray-900">
                                Beranda
                            </a>
                            @auth
                                <a href="{{ route('buku.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Katalog Buku
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold px-3 py-2">
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                        Daftar Akun
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Header -->
        <header class="bg-white shadow-sm border-b border-gray-200/60">
            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Sistem Perpustakaan Digital
                    </h1>
                    <p class="mt-2 text-base text-gray-600 max-w-2xl">
                        Temukan koleksi buku, lakukan peminjaman mandiri, dan pantau status transaksi peminjaman Anda secara online.
                    </p>
                </div>
                @guest
                    <div class="flex gap-3 shrink-0">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                            Mulai Pinjam
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                            Masuk Akun
                        </a>
                    </div>
                @endguest
            </div>
        </header>

        <!-- Content -->
        <main class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Stat Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Koleksi Buku</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalBuku }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Tersedia</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalKategori }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Katalog Buku Grid -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex justify-between items-center pb-4 mb-6 border-b border-gray-200">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Koleksi Buku Terbaru</h2>
                            <p class="text-sm text-gray-500">Daftar buku yang tersedia di sistem perpustakaan</p>
                        </div>
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($bukus as $buku)
                            <div class="border border-gray-200 rounded-lg p-5 bg-gray-50/50 flex flex-col justify-between hover:bg-white hover:shadow-md transition">
                                <div>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $buku->kategori->nama ?? 'Umum' }}
                                        </span>
                                        <span class="text-xs font-medium text-gray-500">Tahun {{ $buku->tahun_terbit }}</span>
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-base mb-1">{{ $buku->judul }}</h3>
                                    <p class="text-xs text-gray-600 mb-4">Penulis: {{ $buku->penulis }}</p>
                                </div>

                                <div>
                                    @guest
                                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-xs tracking-wider uppercase transition">
                                            Login untuk Meminjam
                                        </a>
                                    @else
                                        <a href="{{ route('buku.index') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-xs tracking-wider uppercase transition">
                                            Pinjam Buku
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-500">
                                Belum ada koleksi buku yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Sistem Perpustakaan Digital. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>