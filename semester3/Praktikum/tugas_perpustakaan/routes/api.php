<?php

use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

// Endpoint Rekapitulasi Data API
Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku']);

// Endpoint CRUD Data Buku (index, store, show, update, destroy)
Route::apiResource('buku', BukuController::class);

// Endpoint Mengambil Data Kategori
Route::get('/kategori', function () {
    return response()->json(Kategori::all());
});