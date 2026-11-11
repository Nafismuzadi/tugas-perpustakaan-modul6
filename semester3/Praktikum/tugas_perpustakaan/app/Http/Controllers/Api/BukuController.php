<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Resources\BukuResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar semua buku beserta kategori (JSON).
     */
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->get();

        return BukuResource::collection($buku);
    }

    /**
     * Menyimpan data buku baru (JSON API).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'kategori_id'  => ['required', Rule::exists(Kategori::class, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $buku = Buku::create($request->all());

        return new BukuResource($buku->load('kategori'));
    }

    /**
     * Menampilkan detail 1 buku berdasarkan ID (JSON API).
     */
    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        return new BukuResource($buku);
    }

    /**
     * Memperbarui data buku berdasarkan ID (JSON API).
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul'        => 'sometimes|required|string|max:255',
            'penulis'      => 'sometimes|required|string|max:255',
            'tahun_terbit' => 'sometimes|required|numeric',
            'kategori_id'  => ['sometimes', 'required', Rule::exists(Kategori::class, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $buku->update($request->all());

        return new BukuResource($buku->load('kategori'));
    }

    /**
     * Menghapus data buku (JSON API).
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil dihapus'
        ], 200);
    }
}