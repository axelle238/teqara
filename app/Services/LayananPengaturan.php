<?php

namespace App\Services;

use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

/**
 * Layanan Pengaturan Sistem Terpusat (Advanced)
 * 
 * Mengelola seluruh konfigurasi dinamis aplikasi dengan sistem caching 
 * dan pencatatan audit trail untuk setiap perubahan.
 */
class LayananPengaturan
{
    /**
     * Mengambil nilai pengaturan berdasarkan kunci.
     */
    public function ambil(string $kunci, $default = null)
    {
        $semuaPengaturan = Cache::rememberForever('pengaturan_sistem_global', function () {
            try {
                return PengaturanSistem::pluck('nilai', 'kunci')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        return $semuaPengaturan[$kunci] ?? $default;
    }

    /**
     * Mengambil seluruh pengaturan dalam format array.
     */
    public function ambilSemua()
    {
        return Cache::rememberForever('pengaturan_sistem_global', function () {
            try {
                return PengaturanSistem::pluck('nilai', 'kunci')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });
    }

    /**
     * Menyimpan atau memperbarui pengaturan tunggal.
     */
    public function simpan(string $kunci, $nilai, $tipe = 'string')
    {
        $nilaiLama = $this->ambil($kunci);
        
        PengaturanSistem::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai, 'tipe' => $tipe]
        );

        if ($nilaiLama != $nilai) {
            LogHelper::catat('perbarui_pengaturan', $kunci, "Mengubah konfigurasi '{$kunci}' secara terpusat.");
        }

        $this->bersihkanCache();
    }

    /**
     * Menyimpan banyak pengaturan sekaligus dengan Audit Trail.
     */
    public function simpanBanyak(array $data)
    {
        foreach ($data as $kunci => $nilai) {
            if ($nilai !== null) {
                $nilaiLama = $this->ambil($kunci);
                
                PengaturanSistem::updateOrCreate(
                    ['kunci' => $kunci],
                    ['nilai' => $nilai, 'tipe' => 'string']
                );

                if ($nilaiLama != $nilai) {
                    LogHelper::catat('perbarui_pengaturan', $kunci, "Pengaturan '{$kunci}' diperbarui dalam sesi sinkronisasi massal.");
                }
            }
        }
        $this->bersihkanCache();
    }

    /**
     * Mengatur Mode Pemeliharaan (Maintenance Mode).
     */
    public function setelModePemeliharaan(bool $aktif, string $pesan = '')
    {
        $this->simpan('mode_pemeliharaan', $aktif ? 'aktif' : 'nonaktif');
        $this->simpan('pesan_pemeliharaan', $pesan);
        
        // Logika Artisan Down/Up akan dijalankan oleh sistem backend
        LogHelper::catat('keamanan_sistem', 'Mode Pemeliharaan', "Status mode pemeliharaan diubah menjadi: " . ($aktif ? 'AKTIF' : 'NONAKTIF'));
    }

    /**
     * Upload gambar pengaturan (Logo, Favicon, Banner).
     */
    public function uploadGambar($file, $kunci)
    {
        if ($file) {
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
     * Membersihkan cache pengaturan agar perubahan langsung tampil secara Real-time.
     */
    public function bersihkanCache()
    {
        Cache::forget('pengaturan_sistem_global');
        Cache::forget('global_settings'); // Sync dengan AppServiceProvider
    }
}