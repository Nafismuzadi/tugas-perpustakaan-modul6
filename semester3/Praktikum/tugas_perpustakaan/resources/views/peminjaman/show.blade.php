<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Peminjaman #{{ $peminjaman->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-2"><strong>Peminjam:</strong> {{ $peminjaman->user->name ?? 'Siswa' }}</p>
                <p class="mb-2"><strong>Judul Buku:</strong> {{ $peminjaman->buku->judul ?? '-' }}</p>
                <p class="mb-2"><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
                <p class="mb-2"><strong>Status:</strong> {{ $peminjaman->status }}</p>
            </div>
        </div>
    </div>
</x-app-layout>