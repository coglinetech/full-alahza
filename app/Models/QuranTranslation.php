<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranTranslation extends Model
{
    // Berdasarkan skema asli Tanzil id.indonesian.sql
    protected $table = 'id_indonesian';
    protected $primaryKey = 'index'; // Kolom index adalah Primary Key autoincrement

    // Menonaktifkan timestamps karena Tanzil tidak memilikinya
    public $timestamps = false;

    protected $fillable = [
        'sura',
        'aya',
        'text',
    ];
}
