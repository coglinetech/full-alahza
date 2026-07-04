<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranText extends Model
{
    // Berdasarkan skema asli Tanzil quran-uthmani.sql
    protected $table = 'quran_text';
    protected $primaryKey = 'index'; // Kolom index adalah Primary Key autoincrement

    // Menonaktifkan timestamps karena Tanzil tidak memilikinya
    public $timestamps = false;

    protected $fillable = [
        'sura',
        'aya',
        'text',
    ];
}
