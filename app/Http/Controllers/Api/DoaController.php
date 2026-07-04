<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doa;
use Illuminate\Http\Request;

class DoaController extends Controller
{
    public function index(Request $request)
    {
        $query = Doa::query();
        
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $doas = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Doa & Wirid',
            'data' => $doas
        ]);
    }

    public function show($id)
    {
        $doa = Doa::find($id);

        if (!$doa) {
            return response()->json([
                'success' => false,
                'message' => 'Doa tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Doa',
            'data' => $doa
        ]);
    }
}
