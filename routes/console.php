<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:setup-storage', function () {
    $publicStoragePath = public_path('storage');
    $storagePublicPath = storage_path('app/public');

    if (! is_dir($storagePublicPath)) {
        mkdir($storagePublicPath, 0755, true);
        $this->info('Created storage/app/public directory.');
    }

    foreach (['about', 'gallery', 'packages'] as $dir) {
        Storage::disk('public')->makeDirectory($dir);
    }

    if (file_exists($publicStoragePath) && ! is_dir($publicStoragePath) && ! is_link($publicStoragePath)) {
        $this->error('Cannot create storage link because public/storage exists as a file. Remove it manually first.');

        return self::FAILURE;
    }

    $publicStorageRealPath = is_dir($publicStoragePath) ? realpath($publicStoragePath) : false;
    $storagePublicRealPath = is_dir($storagePublicPath) ? realpath($storagePublicPath) : false;

    if ($publicStorageRealPath !== false && $storagePublicRealPath !== false && $publicStorageRealPath === $storagePublicRealPath) {
        $this->info('public/storage is already linked to storage/app/public.');

        return self::SUCCESS;
    }

    if (is_dir($publicStoragePath) && ! is_link($publicStoragePath)) {
        $this->warn('Found public/storage as a normal directory. Migrating files before creating symlink...');

        File::copyDirectory($publicStoragePath, $storagePublicPath);
        File::deleteDirectory($publicStoragePath);

        $this->info('Moved files from public/storage to storage/app/public.');
    }

    if (is_link($publicStoragePath)) {
        $this->info('public/storage is already linked to storage/app/public.');

        return self::SUCCESS;
    }

    try {
        $this->call('storage:link');
    } catch (\Throwable $e) {
        $this->error('Failed to create storage symlink: '.$e->getMessage());

        return self::FAILURE;
    }

    $this->info('Storage setup completed successfully.');

    return self::SUCCESS;
})->purpose('Repair storage link and ensure upload directories exist');
