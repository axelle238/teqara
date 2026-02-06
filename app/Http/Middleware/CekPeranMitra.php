<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPeranMitra
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || auth()->user()->peran !== 'pemasok') {
            abort(403, 'AKSES DITOLAK: Halaman ini hanya untuk Mitra Bisnis (Supplier).');
        }

        return $next($request);
    }
}