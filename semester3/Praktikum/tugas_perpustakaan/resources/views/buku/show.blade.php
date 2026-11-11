@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200/80 p-6">
            
            <!-- Header Halaman -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Detail Informasi Buku</h1>
                    <p class="text-xs text-gray-500 mt-1">ID Buku: #{{ $buku->id }}</p>
                </div>
                <a href="{{ route('buku.index') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition">
                    &larr; Kembali ke Daftar
                </a>
            </div>

            <!-- Detail Data Buku -->
            <div class="space-y-4 text-sm">
                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-50">
                    <span class="font-medium text-gray-500">Judul Buku</span>
                    <span class="col-span-2 font-bold text-gray-900">{{ $buku->judul }}</span>
                </div>

                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-50">
                    <span class="font-medium text-gray-500">Kategori</span>
                    <span class="col-span-2 text-gray-800">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $buku->kategori->nama_kategori ?? $buku->kategori->nama ?? $buku->kategori ?? '-' }}
                        </span>
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-50">
                    <span class="font-medium text-gray-500">Penulis</span>
                    <span class="col-span-2 text-gray-800">{{ $buku->penulis }}</span>
                </div>

                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-50">
                    <span class="font-medium text-gray-500">Tahun Terbit</span>
                    <span class="col-span-2 text-gray-800">{{ $buku->tahun_terbit }}</span>
                </div>
            </div>

            <!-- Tombol Aksi Khusus Admin & Petugas -->
            <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                @can('kelola data buku')
                    <a href="{{ route('buku.edit', $buku->id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition">
                        Edit Buku
                    </a>

                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg transition">
                            Hapus Buku
                        </button>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</div>
@endsection