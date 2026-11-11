<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'judul'        => $this->judul,
            'penulis'      => $this->penulis,
            'tahun_terbit' => $this->tahun_terbit,
            'kategori'     => [
                'id'            => $this->kategori->id ?? null,
                'nama_kategori' => $this->kategori->nama_kategori ?? $this->kategori->nama ?? null,
            ],
            'created_at'   => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'   => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}