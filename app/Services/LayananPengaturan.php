<?php

namespace App\Services;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Layanan Pengaturan Sistem Terpusat
 * 
 * Mengelola seluruh konfigurasi dinamis aplikasi (Identitas, SEO, Sistem).
 * Menggunakan Cache Layer untuk performa tinggi di sisi Halaman Toko.
 */
class LayananPengaturan
{
    /**
     * Mengambil nilai pengaturan berdasarkan kunci.
     */
    public function ambil(string $kunci, $default = null)
    {
        $semuaPengaturan = Cache::rememberForever('pengaturan_sistem_global', function () {
            return PengaturanSistem::pluck('nilai', 'kunci')->toArray();
        });

        return $semuaPengaturan[$kunci] ?? $default;
    }

    /**
     * Mengambil seluruh pengaturan dalam format array.
     */
    public function ambilSemua()
    {
        return Cache::rememberForever('pengaturan_sistem_global', function () {
            return PengaturanSistem::pluck('nilai', 'kunci')->toArray();
        });
    }

    /**
     * Menyimpan atau memperbarui pengaturan.
     */
    public function simpan(string $kunci, $nilai, $tipe = 'string')
    {
        PengaturanSistem::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai, 'tipe' => $tipe]
        );

        $this->bersihkanCache();
    }

    /**
     * Menyimpan banyak pengaturan sekaligus.
     */
    public function simpanBanyak(array $data)
    {
        foreach ($data as $kunci => $nilai) {
            // Abaikan jika nilai null/kosong agar tidak menimpa dengan blank (opsional, tergantung logic)
            if ($nilai !== null) {
                PengaturanSistem::updateOrCreate(
                    ['kunci' => $kunci],
                    ['nilai' => $nilai, 'tipe' => 'string']
                );
            }
        }
        $this->bersihkanCache();
    }

    /**
     * Upload gambar pengaturan (Logo, Favicon, Banner).
     */
    public function uploadGambar($file, $kunci)
    {
        if ($file) {
            // Hapus gambar lama
            $lama = $this->ambil($kunci);
            if ($lama && Storage::disk('public')->exists(str_replace('/storage/', '', $lama))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $lama));
            }

            $path = $file->store('sistem', 'public');
            $url = '/storage/' . $path;
            $this->simpan($kunci, $url, 'image');
            return $url;
        }
        return null;
    }

    /**
     * Membersihkan cache pengaturan agar perubahan langsung tampil.
     */
    public function bersihkanCache()
    {
        Cache::forget('pengaturan_sistem_global');
    }
}
