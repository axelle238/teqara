<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware Otorisasi Dinamis
 * 
 * Memvalidasi apakah pengguna memiliki hak akses ke fitur/rute yang diminta
 * berdasarkan konfigurasi peran dan hak akses di database.
 */
class OtorisasiDinamis
{
    /**
     * Tangani permintaan yang masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pengguna = $request->user();
        $namaRute = $request->route()->getName();

        // 1. Jika bukan rute pengelola, lewatkan
        if (!str_starts_with($namaRute, 'pengelola.')) {
            return $next($request);
        }

        // 2. Cek izin via model Pengguna
        if ($pengguna && $pengguna->memilikiAkses($namaRute)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, arahkan kembali dengan peringatan atau 403
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Akses ditolak. Anda tidak memiliki izin untuk fitur ini.'], 403);
        }

        return response()->view('errors.403', [
            'message' => 'Anda tidak memiliki hak akses untuk masuk ke modul: ' . str_replace('pengelola.', '', $namaRute)
        ], 403);
    }
}
