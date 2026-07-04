<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Support\ImageUploadService;
use Illuminate\Http\Request;

class BannerAdminController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->latest()->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.form');
    }

    public function store(Request $request, ImageUploadService $uploader)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:500',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url'   => 'nullable|string|max:500',
            'link_label' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $uploader->storeCover($request->file('image'), 'banners', 1920, 600);
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner "' . $data['title'] . '" berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function update(Request $request, Banner $banner, ImageUploadService $uploader)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:500',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url'   => 'nullable|string|max:500',
            'link_label' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $uploader->deleteFromPublicDisk($banner->image_path);
            $data['image_path'] = $uploader->storeCover($request->file('image'), 'banners', 1920, 600);
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    public function toggle(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return back()->with('success', 'Status banner diperbarui.');
    }

    public function destroy(Banner $banner, ImageUploadService $uploader)
    {
        $title = $banner->title;
        $uploader->deleteFromPublicDisk($banner->image_path);
        $banner->delete();
        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner "' . $title . '" berhasil dihapus.');
    }
}
