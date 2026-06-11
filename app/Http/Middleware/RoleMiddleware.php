<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!$request->user()) {
            return redirect('login');
        }

        // Cek apakah role user ada dalam daftar role yang diizinkan
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, arahkan ke dashboard default atau pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses.');
    }
}