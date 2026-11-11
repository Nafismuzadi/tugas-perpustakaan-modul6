<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar semua buku (Blade View).
     */
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->get();

        return view('buku.index', compact('buku'));
    }

    /**
     * Menampilkan form untuk menambah buku baru (Blade View).
     */
    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.create', compact('kategori'));
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'kategori_id'  => ['required', Rule::exists(Kategori::class, 'id')],
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail informasi buku (Blade View).
     */
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('buku.show', compact('buku'));
    }

    /**
     * Menampilkan form untuk mengedit data buku (Blade View).
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Memperbarui data buku di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'kategori_id'  => ['required', Rule::exists(Kategori::class, 'id')],
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Data buku "' . $buku->judul . '" berhasil diperbarui!');
    }

    /**
     * Menghapus data buku dari database.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $namaJudul = $buku->judul;
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku "' . $namaJudul . '" berhasil dihapus!');
    }
}