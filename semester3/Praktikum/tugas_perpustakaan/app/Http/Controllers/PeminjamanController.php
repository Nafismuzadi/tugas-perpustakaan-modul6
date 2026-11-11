<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function store(Request $request, $bukuId)
    {
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $bukuId,
            'tanggal_pinjam' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil.');
    }

    // Soal 3: Method show dengan Otorisasi Gate
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        // Memanggil Gate sentralisasi (Return 403 jika Siswa mengakses peminjaman siswa lain)
        Gate::authorize('view-peminjaman', $peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function riwayatSaya()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())->with('buku')->latest()->get();
        return view('peminjaman.riwayat', compact('peminjamans'));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Disetujui']);
        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Ditolak']);
        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Dikembalikan']);
        return redirect()->back()->with('success', 'Buku telah dikembalikan.');
    }
}