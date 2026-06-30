<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pastikan user sudah login dan memiliki role yang sesuai
        if (!$request->user() || $request->user()->role !== $role) {
            // Sesuai cakupan tugas: lempar error 403 Unauthorized
            abort(403, 'Anda tidak memiliki hak akses untuk memasuki halaman Manajer Cabang.');
        }

        return $next($request);
    }
}