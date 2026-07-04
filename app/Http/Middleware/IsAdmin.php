<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek user sudah login dan punya role admin
        // Sesuaikan kondisi ini dengan kolom yang ada di tabel users Anda
        if (! $request->user() || $request->user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}