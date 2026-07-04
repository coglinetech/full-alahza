<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSessionExpired
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin*') && !Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesi telah berakhir.'], 401);
            }
            return redirect()->route('admin.login')
                ->with('session_expired', true);
        }
        return $next($request);
    }
}