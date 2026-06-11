<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('login');
        }

        // 2. Ambil data user yang sedang login
        $user = auth()->user();

        // 3. Cek apakah role user ada di dalam daftar yang diizinkan (admin/petugas/nasabah)
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 4. Jika tidak punya akses, tendang kembali ke dashboard
        return redirect('dashboard')->with('error', 'Anda tidak memiliki izin akses!');
    }
}