<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->surah->id,
            'nama_latin' => $this->surah->nama_latin,
            'nama_arab' => $this->surah->nama_arab,
            'jumlah_ayat' => $this->surah->jumlah_ayat,
            'tempat_turun' => $this->surah->tempat_turun,
            // Jika ada relasi ayat (dipanggil dari endpoint detail)
            'ayat' => $this->when(isset($this->ayahs), function () {
                return AyahResource::collection($this->ayahs);
            }),
        ];
    }
}
