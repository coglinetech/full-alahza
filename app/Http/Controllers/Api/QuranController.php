<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SurahResource;

class QuranController extends Controller
{
    /**
     * Endpoint 1: Mengambil list 114 surah.
     * GET /api/quran/surahs
     */
    public function index()
    {
        // Ambil data dari tabel surahs (metadata 114 surah)
        $surahs = DB::table('surahs')->orderBy('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Surah Al-Qur\'an',
            'data'    => $surahs
        ]);
    }

    /**
     * Endpoint 2: Mengambil detail surah beserta list ayat dan terjemahannya.
     * GET /api/quran/surahs/{surah_id}
     */
    public function show($id)
    {
        // Validasi ketersediaan surah
        $surah = DB::table('surahs')->where('id', $id)->first();

        if (!$surah) {
            return response()->json([
                'success' => false,
                'message' => 'Surah tidak ditemukan',
            ], 404);
        }

        // Lakukan JOIN query builder yang efisien antara teks arab dan terjemahannya
        // Berdasarkan kolom sura dan aya dari Tanzil sql structure
        $ayahs = DB::table('quran_text as qt')
            ->join('id_indonesian as id_trans', function ($join) {
                $join->on('qt.sura', '=', 'id_trans.sura')
                     ->on('qt.aya', '=', 'id_trans.aya');
            })
            ->where('qt.sura', $id)
            ->orderBy('qt.aya')
            ->select(
                'qt.aya as ayah_number',
                'qt.text as arab_text',
                'id_trans.text as indonesian_translation'
            )
            ->get();

        // Menggunakan SurahResource dan koleksi AyahResource untuk menyusun response
        return response()->json([
            'success' => true,
            'message' => 'Detail Surah',
            'data'    => new SurahResource((object) [
                'surah' => $surah,
                'ayahs' => $ayahs
            ])
        ]);
    }
}
