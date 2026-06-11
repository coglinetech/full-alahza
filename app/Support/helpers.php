<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('has_media')) {
    function has_media(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        $cleanPath = ltrim($path, '/');
        
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        return Storage::disk('public')->exists($cleanPath);
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        $cleanPath = ltrim($path, '/');
        
        // Remove 'storage/' prefix if it accidentally exists to prevent duplication
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        $publicStorageFile = public_path('storage/' . $cleanPath);

        if (is_file($publicStorageFile)) {
            return asset('storage/' . $cleanPath);
        }

        return route('media.file', ['path' => $cleanPath]);
    }
}
