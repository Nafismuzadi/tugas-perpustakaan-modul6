@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Welcome Banner Header -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200/80 p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Dashboard Petugas</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Selamat datang kembali, <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>.
                </p>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    Petugas Perpustakaan
                </span>
            </div>
        </div>

        <!-- Metric & Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Peran & Hak Akses -->
            <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Hak Akses</p>
                    <h2 class="text-lg font-bold text-gray-900 mt-1">Operasional System</h2>
                    <p class="text-xs text-gray-500 mt-1">Mengelola data buku, memproses transaksi peminjaman, dan pengembalian.</p>
                </div>
                <div class="mt-5 pt-3 border-t border-gray-100 text-xs text-gray-400 font-medium">
                    Protected by Spatie RBAC
                </div>
            </div>

            <!-- Card 2: Akses Katalog Buku -->
            <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Katalog Perpustakaan</p>
                    <h2 class="text-lg font-bold text-gray-900 mt-1">Kelola Data Buku</h2>
                    <p class="text-xs text-gray-500 mt-1">Tambah, perbarui, dan tinjau seluruh daftar koleksi buku.</p>
                </div>
                <div class="mt-5 pt-3 border-t border-gray-100">
                    <a href="{{ route('buku.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 transition">
                        Buka Katalog Buku &rarr;
                    </a>
                </div>
            </div>

            <!-- Card 3: Status Sesi -->
            <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Akun</p>
                    <h2 class="text-lg font-bold text-gray-900 mt-1">Terautentikasi</h2>
                    <p class="text-xs text-gray-500 mt-1">Sesi login aktif dengan kredensial Petugas Perpustakaan.</p>
                </div>
                <div class="mt-5 pt-3 border-t border-gray-100 text-xs text-emerald-600 font-medium flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sesi Aktif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection