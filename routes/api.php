<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\JamaahProfileController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BannerController;

// Public routes
Route::get('/banners', [BannerController::class, 'index']);

// Public routes
Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{slug}', [PackageController::class, 'show']);
Route::get('/packages/{packageId}/departures', [PackageController::class, 'departures']);
Route::get('/testimonials', [PackageController::class, 'testimonials']);
Route::get('/faqs', [PackageController::class, 'faqs']);

// Auth routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    Route::get('/registrations', [RegistrationController::class, 'index']);
    Route::post('/registrations', [RegistrationController::class, 'store']);
    Route::get('/registrations/{id}', [RegistrationController::class, 'show']);

    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments/create', [PaymentController::class, 'create']);

    Route::get('/jamaah/profile', [JamaahProfileController::class, 'show']);
    Route::put('/jamaah/profile', [JamaahProfileController::class, 'store']);
    Route::post('/jamaah/profile', [JamaahProfileController::class, 'store']); // Allow POST to mimic PUT with files

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

   
});

 // Quran routes
    Route::get('/quran/surahs', [\App\Http\Controllers\Api\QuranController::class, 'index']);
    Route::get('/quran/surahs/{surah_id}', [\App\Http\Controllers\Api\QuranController::class, 'show']);

// Doa routes
Route::get('/doas', [\App\Http\Controllers\Api\DoaController::class, 'index']);
Route::get('/doas/{id}', [\App\Http\Controllers\Api\DoaController::class, 'show']);
});
