<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    public function storeOptimized(UploadedFile $file, string $directory, int $maxWidth = 1920): string
    {
        $directory = trim($directory, '/');
        Storage::disk('public')->makeDirectory($directory);

        $extension = $this->normalizedExtension($file->getClientOriginalExtension());
        $filename = $directory . '/' . Str::uuid() . '.' . $extension;
        $fullPath = Storage::disk('public')->path($filename);

        $image = ImageManager::usingDriver(\Intervention\Image\Drivers\Gd\Driver::class)
            ->decode($file->getRealPath());

        if ($maxWidth > 0) {
            $image->scaleDown(width: $maxWidth);
        }

        $image->encode($this->buildEncoder($extension))->save($fullPath);

        return $filename;
    }

    public function deleteFromPublicDisk(?string $path): void
    {
        if (!empty($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function normalizedExtension(string $extension): string
    {
        $extension = strtolower($extension);

        if ($extension === 'jpeg') {
            return 'jpg';
        }

        if (in_array($extension, ['jpg', 'png', 'webp'], true)) {
            return $extension;
        }

        return 'jpg';
    }

    private function buildEncoder(string $extension): JpegEncoder|PngEncoder|WebpEncoder
    {
        return match ($extension) {
            'png' => new PngEncoder(interlaced: false, indexed: false),
            'webp' => new WebpEncoder(quality: 90, strip: true),
            default => new JpegEncoder(quality: 90, progressive: true, strip: true),
        };
    }
}
