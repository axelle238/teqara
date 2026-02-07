<?php

namespace App\Services;

use App\Models\InsidenKeamanan;
use App\Models\AturanFirewall;
use App\Models\LogAktivitas;
use App\Models\LogApi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class LayananKeamanan
{
    /**
     * Hitung Skor Risiko Global (0-100)
     */
    public function hitungSkorRisiko(): int
    {
        return Cache::remember('skor_risiko_keamanan', 300, function () {
            $skor = 100;

            // Kurangi berdasarkan insiden 24 jam terakhir
            $insidenKritis = InsidenKeamanan::where('tingkat_keparahan', 'kritis')
                ->where('dibuat_pada', '>=', now()->subDay())
                ->count();
            $skor -= ($insidenKritis * 15);

            $insidenTinggi = InsidenKeamanan::where('tingkat_keparahan', 'tinggi')
                ->where('dibuat_pada', '>=', now()->subDay())
                ->count();
            $skor -= ($insidenTinggi * 5);

            // Kurangi jika ada file yang tidak berintegritas (simulasi)
            if (Cache::get('file_integrity_failed', false)) {
                $skor -= 20;
            }

            // Batasi skor minimum 0
            return max(0, $skor);
        });
    }

    /**
     * Deteksi Pola Serangan Otomatis dari Log
     */
    public function deteksiAncamanOtomatis(): array
    {
        $ancaman = [];
        
        // Cek Brute Force (10+ kegagalan login dari IP yang sama dalam 5 menit)
        // Extract IP dari JSON meta_data
        $bruteForceIps = LogAktivitas::where('aksi', 'login_gagal')
            ->where('waktu', '>=', now()->subMinutes(5))
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(meta_data, '$.alamat_ip')) as ip")
            ->groupBy('ip')
            ->havingRaw('count(*) > 10')
            ->get();

        foreach ($bruteForceIps as $log) {
            if (!$log->ip) continue;
            $ancaman[] = [
                'tipe' => 'Percobaan Brute Force',
                'ip' => $log->ip,
                'level' => 'tinggi',
                'rekomendasi' => 'Blokir IP secara permanen'
            ];
        }

        // Cek SQL Injection Patterns di API Logs
        $sqlPatterns = ["'", "--", "union select", "information_schema", "drop table"];
        $apiAnomalies = LogApi::where('dibuat_pada', '>=', now()->subHour())
            ->where(function($query) use ($sqlPatterns) {
                foreach($sqlPatterns as $p) {
                    $query->orWhere('payload', 'like', "%$p%");
                }
            })->get();

        foreach ($apiAnomalies as $log) {
            $ancaman[] = [
                'tipe' => 'Potensi SQL Injection',
                'ip' => $log->alamat_ip,
                'level' => 'kritis',
                'rekomendasi' => 'Tinjau payload dan blokir IP'
            ];
        }

        return $ancaman;
    }

    /**
     * Periksa Integritas File Inti (Simulasi)
     */
    public function periksaIntegritasSistem(): array
    {
        $filePenting = [
            base_path('.env'),
            base_path('artisan'),
            app_path('Providers/AppServiceProvider.php'),
            public_path('index.php'),
        ];

        $hasil = [];
        foreach ($filePenting as $file) {
            if (File::exists($file)) {
                $hash = md5_file($file);
                // Di dunia nyata, bandingkan dengan hash yang disimpan saat deployment
                $hasil[] = [
                    'file' => basename($file),
                    'status' => 'aman',
                    'hash' => $hash,
                    'last_modified' => File::lastModified($file)
                ];
            }
        }

        return $hasil;
    }

    /**
     * Analisis Distribusi Geografis (Simulasi)
     */
    public function dapatkanAnalisisGeo(): array
    {
        // Simulasi data GeoIP
        return [
            ['negara' => 'Indonesia', 'total' => 150, 'lat' => -6.2088, 'lng' => 106.8456],
            ['negara' => 'Russia', 'total' => 45, 'lat' => 61.5240, 'lng' => 105.3188],
            ['negara' => 'China', 'total' => 30, 'lat' => 35.8617, 'lng' => 104.1954],
            ['negara' => 'United States', 'total' => 20, 'lat' => 37.0902, 'lng' => -95.7129],
            ['negara' => 'Netherlands', 'total' => 15, 'lat' => 52.1326, 'lng' => 5.2913],
        ];
    }
}
