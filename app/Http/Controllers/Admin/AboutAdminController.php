<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\ImageUploadService;
use Illuminate\Http\Request;

class AboutAdminController extends Controller
{
    public function index()
{
    $aboutStats = [
        'jamaah_count'    => SiteSetting::getValue('about_jamaah_count', 2500),
        'tahun_berdiri'   => SiteSetting::getValue('about_tahun_berdiri', 2010),
        'destinasi_count' => SiteSetting::getValue('about_destinasi_count', 12),
        'rating_pct'      => SiteSetting::getValue('about_rating_pct', 98),
    ];

    // 🔥 TAMBAHAN INI
    $aboutImage = (object) [
        'image_path' => SiteSetting::getValue('about_image_path'),
        'updated_at' => now() // optional biar ga error
    ];

    return view('admin.about.index', compact('aboutStats', 'aboutImage'));
}

    public function update(Request $request, ImageUploadService $imageUploadService)
    {
        $request->validate([
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image'    => 'nullable|in:0,1',
            'jamaah_count'    => 'required|integer|min:0',
            'tahun_berdiri'   => 'required|integer|min:1900',
            'destinasi_count' => 'required|integer|min:0',
            'rating_pct'      => 'required|integer|min:0|max:100',
        ]);

        $oldImagePath = SiteSetting::getValue('about_image_path');

        if ($request->boolean('remove_image') && $oldImagePath) {
            $imageUploadService->deleteFromPublicDisk($oldImagePath);
            SiteSetting::where('key', 'about_image_path')->delete();
            $oldImagePath = null;
        }

        if ($request->hasFile('image')) {
            $imageUploadService->deleteFromPublicDisk($oldImagePath);
            $path = $imageUploadService->storeOptimized(
                $request->file('image'),
                'about',
                1600
            );
            SiteSetting::setValue('about_image_path', $path);
        }

        SiteSetting::setValue('about_jamaah_count',    $request->jamaah_count);
        SiteSetting::setValue('about_tahun_berdiri',   $request->tahun_berdiri);
        SiteSetting::setValue('about_destinasi_count', $request->destinasi_count);
        SiteSetting::setValue('about_rating_pct',      $request->rating_pct);

        return back()->with('success', 'Data about berhasil diperbarui.');
    }
}