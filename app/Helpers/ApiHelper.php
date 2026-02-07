<?php

namespace App\Helpers;

use App\Models\LogApi;

class ApiHelper
{
    /**
     * Catat log permintaan API untuk monitoring dan audit.
     *
     * @param int|null $kunciApiId
     * @param string $endpoint
     * @param string $metode
     * @param string $ip
     * @param array|null $payload
     * @param int $statusKode
     * @param float $durasi (dalam ms)
     */
    public static function log($kunciApiId, $endpoint, $metode, $ip, $payload, $statusKode, $durasi)
    {
        try {
            LogApi::create([
                'kunci_api_id' => $kunciApiId,
                'endpoint' => $endpoint,
                'metode' => $metode,
                'ip_address' => $ip,
                'payload' => $payload,
                'respons_kode' => $statusKode,
                'waktu_eksekusi' => $durasi,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mencatat log API: ' . $e->getMessage());
        }
    }
}
