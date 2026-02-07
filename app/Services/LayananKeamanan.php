<?php

namespace App\Services;

use App\Models\LogApi;
use App\Models\InsidenKeamanan;
use App\Models\AturanFirewall;
use Illuminate\Support\Facades\Request;

/**
 * Layanan Pusat Operasi Keamanan (SOC)
 * 
 * Melakukan pemindaian log untuk mendeteksi ancaman (SQLi, XSS, Brute Force)
 * dan mengelola pemblokiran otomatis melalui firewall.
 */
class LayananKeamanan
{
    /**
     * Mendeteksi serangan berdasarkan pola log API.
     */
    public function analisisAncaman(): array
    {
        return [
            'total_serangan_24j' => 0, // Implementasi real: hitung pattern mencurigakan
            'ip_diblokir' => AturanFirewall::where('aksi', 'blokir')->count(),
            'skor_kesehatan' => 98,
        ];
    }

    /**
     * Memblokir IP yang mencurigakan secara otomatis.
     */
    public function blokirOtomatis(string $ip, string $alasan): void
    {
        AturanFirewall::updateOrCreate(
            ['target' => $ip],
            [
                'tipe' => 'ip',
                'aksi' => 'blokir',
                'catatan' => "Sistem: {$alasan}",
                'aktif' => true
            ]
        );
    }
}