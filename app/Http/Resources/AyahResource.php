<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AyahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nomor_ayat' => $this->ayah_number,
            'teks_arab'  => $this->arab_text,
            'terjemahan' => $this->indonesian_translation,
        ];
    }
}
