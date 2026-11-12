<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Tugas 2 Sesi 19: Middleware untuk membatasi akses Admin.
     * Pengguna yang bukan admin (role != 'admin') akan ditolak (403 Forbidden).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user adalah 'admin'
        if (strtolower($request->user()->role ?? '') !== 'admin') {
            abort(403, 'Akses Ditolak! Halaman ini hanya dapat diakses oleh Administrator.');
        }

        return $next($request);
    }
}
