<?php

namespace App\Http\Middleware;

use App\Models\AturanFirewall;
use App\Models\InsidenKeamanan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirewallKeamanan
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // 1. Cek Blokir IP
        $terblokir = AturanFirewall::where('aktif', true)
            ->where('tipe_aturan', 'blokir')
            ->where(function ($query) use ($ip, $userAgent) {
                $query->where('alamat_ip', $ip)
                      ->orWhere('user_agent', 'like', "%$userAgent%");
            })
            ->first();

        if ($terblokir) {
            // Catat insiden akses terblokir (throttled)
            if (rand(1, 10) === 1) { // Jangan catat setiap request agar tidak flooding
                InsidenKeamanan::create([
                    'jenis_insiden' => 'Blocked Access Attempt',
                    'tingkat_keparahan' => 'rendah',
                    'alamat_ip' => $ip,
                    'deskripsi' => "IP terblokir mencoba mengakses {$request->fullUrl()}",
                    'meta_data' => ['rule_id' => $terblokir->id, 'reason' => $terblokir->alasan]
                ]);
            }

            return response()->view('errors.403', [
                'message' => 'Akses Anda diblokir oleh sistem keamanan Teqara SOC karena aktivitas mencurigakan.'
            ], 403);
        }

        // 2. Deteksi SQL Injection Sederhana (Pattern Matching)
        $input = json_encode($request->all());
        $patterns = ["'--", "union select", "information_schema", "drop table"];
        foreach ($patterns as $pattern) {
            if (stripos($input, $pattern) !== false) {
                // Auto Block IP
                AturanFirewall::create([
                    'alamat_ip' => $ip,
                    'tipe_aturan' => 'blokir',
                    'alasan' => 'Auto-Block: SQL Injection Pattern Detected',
                    'aktif' => true,
                    'level_ancaman' => 'kritis'
                ]);

                InsidenKeamanan::create([
                    'jenis_insiden' => 'SQL Injection Attack',
                    'tingkat_keparahan' => 'kritis',
                    'alamat_ip' => $ip,
                    'deskripsi' => "Serangan SQLi terdeteksi pada URL: {$request->fullUrl()}",
                    'meta_data' => ['input' => $input, 'pattern' => $pattern]
                ]);

                return response()->json(['error' => 'Security Threat Detected. IP Blocked.'], 403);
            }
        }

        return $next($request);
    }
}