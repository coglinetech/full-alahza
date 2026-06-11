<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Support\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PackageAdminController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.form');
    }

    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $categories = Package::categories();

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'required|string|unique:packages,slug|max:255',
            'category'     => ['required', Rule::in($categories)],
            'duration'     => 'required|string|max:100',
            'price_start'  => 'required|numeric|min:0',
            'destination'  => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'highlights'   => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['slug']       = Str::slug($data['slug']);
        $data['highlights'] = array_filter($data['highlights'] ?? []);

        if ($request->hasFile('image')) {
            $data['image_path'] = $imageUploadService->storeOptimized(
                $request->file('image'),
                'packages',
                1920
            );
        }

        Package::create($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket "' . $data['name'] . '" berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.form', compact('package'));
    }

    public function update(Request $request, Package $package, ImageUploadService $imageUploadService)
    {
        $categories = Package::categories();

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'required|string|unique:packages,slug,' . $package->id . '|max:255',
            'category'     => ['required', Rule::in($categories)],
            'duration'     => 'required|string|max:100',
            'price_start'  => 'required|numeric|min:0',
            'destination'  => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'highlights'   => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image' => 'nullable|in:0,1',
        ]);

        $data['slug']       = Str::slug($data['slug']);
        $data['highlights'] = array_filter($data['highlights'] ?? []);

        if ($request->boolean('remove_image') && $package->image_path) {
            $imageUploadService->deleteFromPublicDisk($package->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $imageUploadService->deleteFromPublicDisk($package->image_path);
            $data['image_path'] = $imageUploadService->storeOptimized(
                $request->file('image'),
                'packages',
                1920
            );
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket "' . $package->name . '" berhasil diperbarui.');
    }

    public function destroy(Package $package, ImageUploadService $imageUploadService)
    {
        $imageUploadService->deleteFromPublicDisk($package->image_path);
        $name = $package->name;
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket "' . $name . '" berhasil dihapus.');
    }
}