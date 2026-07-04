<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\PaymentController;

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
});