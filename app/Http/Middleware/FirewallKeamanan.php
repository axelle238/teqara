<?php

namespace App\Http\Middleware;

use App\Models\AturanFirewall;
use App\Models\InsidenKeamanan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware Firewall Keamanan
 * 
 * Melindungi sistem dari akses terlarang (IP/User Agent terblokir)
 * dan deteksi dasar serangan injeksi SQL.
 */
class FirewallKeamanan
{
    /**
     * Tangani permintaan yang masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $agenPengguna = $request->userAgent();

        // 1. Cek Blokir IP atau Agen Pengguna
        $terblokir = AturanFirewall::where('aktif', true)
            ->where('tipe_aturan', 'blokir')
            ->where(function ($query) use ($ip, $agenPengguna) {
                $query->where('alamat_ip', $ip)
                      ->orWhere('agen_pengguna', 'like', "%$agenPengguna%");
            })
            ->first();

        if ($terblokir) {
            // Catat insiden akses terblokir (throttled)
            if (rand(1, 10) === 1) { // Sampling agar tidak memenuhi log
                InsidenKeamanan::create([
                    'jenis_insiden' => 'Percobaan Akses Terblokir',
                    'tingkat_keparahan' => 'rendah',
                    'alamat_ip' => $ip,
                    'deskripsi' => "IP terblokir mencoba mengakses {$request->fullUrl()}",
                    'meta_data' => ['id_aturan' => $terblokir->id, 'alasan' => $terblokir->alasan]
                ]);
            }

            return response()->view('errors.403', [
                'message' => 'Akses Anda diblokir oleh sistem keamanan Teqara SOC karena aktivitas mencurigakan.'
            ], 403);
        }

        // 2. Deteksi SQL Injection Sederhana (Pencocokan Pola)
        $input = json_encode($request->all());
        $pola = ["'--", "union select", "information_schema", "drop table"];
        foreach ($pola as $p) {
            if (stripos($input, $p) !== false) {
                // Blokir IP Otomatis
                AturanFirewall::create([
                    'alamat_ip' => $ip,
                    'tipe_aturan' => 'blokir',
                    'alasan' => 'Blokir Otomatis: Pola SQL Injection Terdeteksi',
                    'aktif' => true,
                    'level_ancaman' => 'kritis'
                ]);

                InsidenKeamanan::create([
                    'jenis_insiden' => 'Serangan SQL Injection',
                    'tingkat_keparahan' => 'kritis',
                    'alamat_ip' => $ip,
                    'deskripsi' => "Serangan SQLi terdeteksi pada URL: {$request->fullUrl()}",
                    'meta_data' => ['input' => $input, 'pola' => $p]
                ]);

                return response()->json(['error' => 'Ancaman Keamanan Terdeteksi. IP Diblokir.'], 403);
            }
        }

        return $next($request);
    }
}
