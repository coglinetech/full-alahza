<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Controllers — Public
use App\Http\Controllers\PageController;


// Controllers — Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PackageAdminController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use App\Http\Controllers\Admin\GalleryAdminController;
use App\Http\Controllers\Admin\AboutAdminController;
use App\Http\Controllers\Admin\RegistrantAdminController;
use App\Http\Controllers\Admin\ReceiptAdminController;

Route::get('/media/{path}', function (string $path) {
    if (str_contains($path, '..')) {
        abort(404);
    }

    $path = ltrim($path, '/');

    if (str_starts_with($path, 'storage/')) {
        $path = substr($path, 8);
    }

    abort_unless(Storage::disk('public')->exists($path), 404);

    return response()->file(Storage::disk('public')->path($path), [
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*')->name('media.file');

// ================================================================
//  PUBLIC ROUTES
// ================================================================

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/paket/{slug}', [PageController::class, 'packageDetail'])->name('package.detail');

// ================================================================
//  ADMIN AUTH ROUTES (Login / Logout)
// ================================================================

Route::prefix('admin')->name('admin.')->middleware('admin.nocache')->group(function () {

    // Halaman login — hanya untuk guest (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', function () {
            return view('admin.login');
        })->name('login');

        Route::post('/login', function (\Illuminate\Http\Request $request) {
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        })->name('login.post');
    });

    // Logout
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');

});

// ================================================================
//  ADMIN PROTECTED ROUTES
//  Middleware: auth (sudah login) + is_admin (role check manual)
// ================================================================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin', 'admin.nocache'])->group(function () {

    // ── Dashboard ──────────────────────────────────────────────
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ── Packages ───────────────────────────────────────────────
    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/',              [PackageAdminController::class, 'index'])->name('index');
        Route::get('/create',        [PackageAdminController::class, 'create'])->name('create');
        Route::post('/',             [PackageAdminController::class, 'store'])->name('store');
        Route::get('/{package}/edit',[PackageAdminController::class, 'edit'])->name('edit');
        Route::put('/{package}',     [PackageAdminController::class, 'update'])->name('update');
        Route::delete('/{package}',  [PackageAdminController::class, 'destroy'])->name('destroy');
    });

    // ── Testimonials ───────────────────────────────────────────
    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/',                    [TestimonialAdminController::class, 'index'])->name('index');
        Route::get('/create',              [TestimonialAdminController::class, 'create'])->name('create');
        Route::post('/',                   [TestimonialAdminController::class, 'store'])->name('store');
        Route::get('/{testimonial}/edit',  [TestimonialAdminController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}',       [TestimonialAdminController::class, 'update'])->name('update');
        Route::patch('/{testimonial}/toggle', [TestimonialAdminController::class, 'toggle'])->name('toggle');
        Route::delete('/{testimonial}',    [TestimonialAdminController::class, 'destroy'])->name('destroy');
    });

    // ── Gallery ────────────────────────────────────────────────
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/',               [GalleryAdminController::class, 'index'])->name('index');
        Route::get('/create',         [GalleryAdminController::class, 'create'])->name('create');
        Route::post('/',              [GalleryAdminController::class, 'store'])->name('store');
        Route::get('/{gallery}/edit', [GalleryAdminController::class, 'edit'])->name('edit');
        Route::put('/{gallery}',      [GalleryAdminController::class, 'update'])->name('update');
        Route::delete('/{gallery}',   [GalleryAdminController::class, 'destroy'])->name('destroy');
    });

    // ── Pendaftaran Jamaah Umrah ───────────────────────────────
    Route::prefix('registrants')->name('registrants.')->group(function () {
        Route::get('/', [RegistrantAdminController::class, 'index'])->name('index');
        Route::get('/create', [RegistrantAdminController::class, 'create'])->name('create');
        Route::post('/', [RegistrantAdminController::class, 'store'])->name('store');
        Route::get('/{registrant}/edit', [RegistrantAdminController::class, 'edit'])->name('edit');
        Route::put('/{registrant}', [RegistrantAdminController::class, 'update'])->name('update');
        Route::delete('/{registrant}', [RegistrantAdminController::class, 'destroy'])->name('destroy');
        Route::post('/preview', [RegistrantAdminController::class, 'preview'])->name('preview');
        Route::get('/{registrant}', [RegistrantAdminController::class, 'show'])->name('show');
    });

    Route::prefix('receipts')->name('receipts.')->group(function () {
        Route::get('/', [ReceiptAdminController::class, 'index'])->name('index');
        Route::get('/create', [ReceiptAdminController::class, 'create'])->name('create');
        Route::post('/', [ReceiptAdminController::class, 'store'])->name('store');
        Route::get('/{receipt}/edit', [ReceiptAdminController::class, 'edit'])->name('edit');
        Route::put('/{receipt}', [ReceiptAdminController::class, 'update'])->name('update');
        Route::delete('/{receipt}', [ReceiptAdminController::class, 'destroy'])->name('destroy');
        Route::post('/preview', [ReceiptAdminController::class, 'preview'])->name('preview');
        Route::get('/{receipt}', [ReceiptAdminController::class, 'show'])->name('show');
    });

    // ── About / Site Settings ──────────────────────────────────
    Route::prefix('about')->name('about.')->group(function () {
        Route::get('/',  [AboutAdminController::class, 'index'])->name('index');
        Route::put('/',  [AboutAdminController::class, 'update'])->name('update');
    });
    // ── Session Check (untuk deteksi sesi expired via AJAX) ────
    Route::get('/session-check', function () {
        return response()->json(['ok' => true]);
    })->name('session.check');

    // ── Ganti Password ─────────────────────────────────────────
    Route::get('/password', function () {
        return view('admin.password');
    })->name('password');

    Route::put('/password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => $request->new_password,
        ]);

        return redirect()->route('admin.password')
            ->with('success', 'Password berhasil diubah.');
    })->name('password.update');
});