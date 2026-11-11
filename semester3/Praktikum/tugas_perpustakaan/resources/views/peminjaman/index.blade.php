@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200/80 p-6">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Persetujuan & Kelola Peminjaman</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar pengajuan peminjaman dan transaksi buku perpustakaan.</p>
                </div>
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
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 px-4">Judul Buku</th>
                            <th class="py-3 px-4">Tgl Pinjam</th>
                            <th class="py-3 px-4">Tgl Kembali</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse ($peminjaman as $p)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $p->user->name ?? 'User Dihapus' }}</td>
                                <td class="py-3 px-4">{{ $p->buku->judul ?? 'Buku Dihapus' }}</td>
                                <td class="py-3 px-4">{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') : '-' }}</td>
                                <td class="py-3 px-4">{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') : '-' }}</td>
                                <td class="py-3 px-4">
                                    @if($p->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif($p->status === 'dipinjam')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Sedang Dipinjam
                                        </span>
                                    @elseif($p->status === 'ditolak')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($p->status === 'pending')
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('peminjaman.setujui', $p->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-xs px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-medium transition">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('peminjaman.tolak', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pengajuan peminjaman ini?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-xs px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white rounded font-medium transition">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($p->status === 'dipinjam')
                                        <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-xs px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded font-medium transition">
                                                Proses Pengembalian
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data pengajuan atau peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection