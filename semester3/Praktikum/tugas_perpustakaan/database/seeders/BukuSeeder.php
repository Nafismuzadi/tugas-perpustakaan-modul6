<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Penyesuaian nama kolom menjadi 'nama'
        $kategoriTekno = Kategori::firstOrCreate(['nama' => 'Teknologi']);
        $kategoriNovel = Kategori::firstOrCreate(['nama' => 'Novel']);
        $kategoriSains = Kategori::firstOrCreate(['nama' => 'Sains']);

        // Buat Buku Sampel
        Buku::create([
            'judul'        => 'Pemrograman Web dengan Laravel',
            'penulis'      => 'John Doe',
            'tahun_terbit' => 2024,
            'kategori_id'  => $kategoriTekno->id,
        ]);

        Buku::create([
            'judul'        => 'Laskar Pelangi',
            'penulis'      => 'Andrea Hirata',
            'tahun_terbit' => 2005,
            'kategori_id'  => $kategoriNovel->id,
        ]);

        Buku::create([
            'judul'        => 'Pengantar Fisika Kuantum',
            'penulis'      => 'Albert S.',
            'tahun_terbit' => 2022,
            'kategori_id'  => $kategoriSains->id,
        ]);
    }
}