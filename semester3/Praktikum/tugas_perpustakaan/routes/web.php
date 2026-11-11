<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeminjamanController;
use App\Models\Buku;
use App\Models\Kategori;

// 1. Beranda Utama (Guest / Tanpa Login)
Route::get('/', function () {
    $bukus = Buku::with('kategori')->latest()->take(6)->get();
    $totalBuku = Buku::count();
    $totalKategori = Kategori::count();

    return view('beranda', compact('bukus', 'totalBuku', 'totalKategori'));
})->name('beranda');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // Pengalihan Dashboard Berdasarkan Role
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('Petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('buku.index');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Area Admin
    Route::middleware(['role:Admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Area Petugas
    Route::middleware(['role:Petugas'])->prefix('petugas')->group(function () {
        Route::get('/dashboard', function () {
            return view('petugas.dashboard');
        })->name('petugas.dashboard');
    });

    // Kelola Buku (Admin & Petugas)
    Route::middleware(['permission:kelola data buku'])->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });

    // Lihat Buku (Semua Role)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');

    // Kelola Peminjaman & Persetujuan (Admin & Petugas)
    Route::middleware(['role:Admin|Petugas'])->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::put('/peminjaman/setujui/{id}', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::put('/peminjaman/tolak/{id}', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    });

    // Pengajuan & Pengembalian Buku
    Route::post('/peminjaman/pinjam/{bukuId}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::get('/riwayat-saya', [PeminjamanController::class, 'riwayatSaya'])->name('peminjaman.riwayat_saya');

    // ==========================================
    // SIMULASI SOAL 1: CELAH A2 (SQL INJECTION)
    // ==========================================
    Route::get('/buku-cari', function (\Illuminate\Http\Request $request) {
    $judul = $request->query('judul');
    $bukus = DB::select("SELECT * FROM bukus WHERE judul = ?", [$judul]);
    return response()->json($bukus);
    });

    // Celah A3: Hapus Buku via GET (Rentan CSRF)
    // Route::get('/buku/{id}/hapus', [BukuController::class, 'destroy'])->name('buku.hapus.vulnerable');

    // Celah A4: Detail Peminjaman Tanpa Cek Pemilik (IDOR)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

});