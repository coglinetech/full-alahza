<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Support\ImageUploadService;
use Illuminate\Http\Request;

class GalleryAdminController extends Controller
{
    public function index()
    {
        $images = GalleryImage::ordered()->orderBy('created_at')->paginate(24);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.form');
    }

    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $data = $request->validate($this->validationRules(imageRequired: true));

        $data['image_path'] = $this->storeUploadedImage($request, $imageUploadService);
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['image']);

        GalleryImage::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto berhasil diupload ke galeri.');
    }

    public function edit(GalleryImage $gallery)
    {
        $image = $gallery;
        return view('admin.gallery.form', compact('image'));
    }

    public function update(Request $request, GalleryImage $gallery, ImageUploadService $imageUploadService)
    {
        $data = $request->validate($this->validationRules());

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeUploadedImage(
                $request,
                $imageUploadService,
                $gallery->image_path
            );
        }

        $data['is_active'] = $request->boolean('is_active');
        unset($data['image']);

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(GalleryImage $gallery, ImageUploadService $imageUploadService)
    {
        $imageUploadService->deleteFromPublicDisk($gallery->image_path);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }

    private function validationRules(bool $imageRequired = false): array
    {
        $imageRulePrefix = $imageRequired ? 'required' : 'nullable';

        return [
            'image' => $imageRulePrefix . '|image|mimes:jpg,jpeg,png,webp|max:10240',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    private function storeUploadedImage(
        Request $request,
        ImageUploadService $imageUploadService,
        ?string $oldPath = null
    ): string {
        if (! empty($oldPath)) {
            $imageUploadService->deleteFromPublicDisk($oldPath);
        }

        return $imageUploadService->storeOptimized(
            $request->file('image'),
            'gallery',
            1920
        );
    }
}