<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CekDepartemen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $kodeDepartemen): Response
    {
        $user = auth()->user();

        // Super Admin (ID 1) selalu lolos
        if ($user->id === 1) {
            return $next($request);
        }

        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->join('departemen', 'jabatan.departemen_id', '=', 'departemen.id')
            ->where('karyawan.pengguna_id', $user->id)
            ->select('departemen.kode')
            ->first();

        if (!$karyawan || $karyawan->kode !== $kodeDepartemen) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang departemen.');
        }

        return $next($request);
    }
}