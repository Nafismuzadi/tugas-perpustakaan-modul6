@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200/80 p-6">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Daftar Koleksi Buku</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan lihat seluruh daftar buku perpustakaan.</p>
                </div>
                
                @can('kelola data buku')
                    <a href="{{ route('buku.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                        + Tambah Buku Baru
                    </a>
                @endcan
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 text-sm rounded-lg border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-rose-50 text-rose-700 text-sm rounded-lg border border-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Judul</th>
                            <th class="py-3 px-4">Penulis</th>
                            <th class="py-3 px-4">Tahun Terbit</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($buku as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        {{ $item->kategori->nama_kategori ?? $item->kategori->nama ?? $item->kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-900">{{  $item->judul  }}</td>
                                {{-- bagian sini diubah --}}
                                {{-- <td class="py-3 px-4 font-medium text-gray-900">{!! $item->judul !!}</td> --}}
                                <td class="py-3 px-4">{{ $item->penulis }}</td>
                                <td class="py-3 px-4">{{ $item->tahun_terbit }}</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('buku.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                                            Detail
                                        </a>

                                        @role('Siswa')
                                            <form action="{{ route('peminjaman.store', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold">
                                                    Ajukan Pinjam
                                                </button>
                                            </form>
                                        @endrole

                                        @can('kelola data buku')
                                            <a href="{{ route('buku.edit', $item->id) }}" class="text-amber-600 hover:text-amber-800 text-xs font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku {{ $item->judul }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500 font-medium">
                                    Belum ada data buku yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection