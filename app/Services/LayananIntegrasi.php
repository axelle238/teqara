<?php

namespace App\Services;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Cache;

/**
 * Layanan Integrasi Pihak Ketiga
 * 
 * Mengelola kredensial dan status konektivitas untuk Payment Gateway, 
 * Logistik, WhatsApp, dan Layanan Email secara terpusat.
 */
class LayananIntegrasi
{
    /**
     * Mengambil konfigurasi integrasi tertentu.
     */
    public function ambilKonfigurasi(string $kategori): array
    {
        return Cache::rememberForever("integrasi_{$kategori}", function () use ($kategori) {
            return PengaturanSistem::where('kunci', 'like', "api_{$kategori}_%")->pluck('nilai', 'kunci')->toArray();
        });
    }

    /**
     * Memperbarui kredensial integrasi.
     */
    public function simpanKonfigurasi(array $data, string $kategori): void
    {
        foreach ($data as $kunci => $nilai) {
            PengaturanSistem::updateOrCreate(
                ['kunci' => $kunci],
                ['nilai' => $nilai, 'tipe' => 'password']
            );
        }
        Cache::forget("integrasi_{$kategori}");
    }

    /**
     * Simulasi Cek Koneksi ke Provider.
     */
    public function cekStatus(string $provider): array
    {
        // Logic real akan menggunakan Guzzle/Http Client ke endpoint provider
        return [
            'status' => 'online',
            'latensi' => rand(50, 200) . 'ms',
            'terakhir_dicek' => now()->format('H:i:s')
        ];
    }
}