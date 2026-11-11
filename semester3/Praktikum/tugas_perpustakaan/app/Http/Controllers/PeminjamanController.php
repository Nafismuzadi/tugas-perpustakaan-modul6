<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan seluruh data peminjaman & pengajuan (Khusus Admin & Petugas).
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->latest()->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan riwayat pengajuan & peminjaman milik Siswa.
     */
    public function riwayatSaya()
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('peminjaman.riwayat', compact('peminjaman'));
    }

    /**
     * Mengajukan peminjaman buku oleh Siswa (Status awal: Pending).
     */
    public function store(Request $request, $bukuId)
    {
        $user = Auth::user();
        $buku = Buku::findOrFail($bukuId);

        $sedangDiprosesAtauDipinjam = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $bukuId)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->first();

        if ($sedangDiprosesAtauDipinjam) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan atau sedang meminjam buku "' . $buku->judul . '". Harap tunggu proses persetujuan atau kembalikan buku terlebih dahulu.');
        }

        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $bukuId,
            'status'  => 'pending',
        ]);

        return redirect()->route('peminjaman.riwayat_saya')
            ->with('success', 'Pengajuan peminjaman buku "' . $buku->judul . '" berhasil dikirim. Menunggu persetujuan Petugas/Admin.');
    }

    /**
     * Menyetujui Pengajuan Peminjaman (Khusus Admin & Petugas).
     */
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status'         => 'dipinjam',
            'tanggal_pinjam' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman disetujui!');
    }

    /**
     * Menolak Pengajuan Peminjaman (Khusus Admin & Petugas).
     */
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman ditolak.');
    }

    /**
     * Memproses Pengembalian Buku.
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (!Auth::user()->hasRole(['Admin', 'Petugas']) && $peminjaman->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku belum disetujui atau sudah dikembalikan.');
        }

        $peminjaman->update([
            'tanggal_kembali' => Carbon::now(),
            'status'          => 'dikembalikan',
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }


    // Celah A4: Menampilkan data tanpa memverifikasi kepemilikan user_id
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }
}