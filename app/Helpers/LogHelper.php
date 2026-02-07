<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Helper Log Aktivitas Enterprise
 * 
 * Mengelola pencatatan setiap jejak audit sistem dengan format naratif
 * yang mudah dipahami manusia dan metadata lengkap untuk forensik.
 */
class LogHelper
{
    /**
     * Mencatat aksi pengguna ke dalam Audit Trail.
     *
     * @param string $aksi Jenis aksi (misal: 'Tambah Produk', 'Hapus Pesanan')
     * @param string $target Identitas objek (misal: SKU Produk, Nomor Faktur)
     * @param string $pesan Narasi lengkap kejadian
     * @param array|null $dataSebelum Snapshot data sebelum perubahan
     * @param array|null $dataSesudah Snapshot data setelah perubahan
     */
    public static function catat(string $aksi, string $target, string $pesan, ?array $dataSebelum = null, ?array $dataSesudah = null): void
    {
        try {
            LogAktivitas::create([
                'pengguna_id' => Auth::id(),
                'aksi' => $aksi,
                'target' => $target,
                'pesan_naratif' => $pesan,
                'meta_data' => [
                    'ip' => Request::ip(),
                    'agen' => Request::userAgent(),
                    'url' => Request::fullUrl(),
                    'metode' => Request::method(),
                    'data_lama' => $dataSebelum,
                    'data_baru' => $dataSesudah,
                    'perbedaan' => self::hitungPerbedaan($dataSebelum, $dataSesudah),
                ],
                'waktu' => now(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Audit Trail Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Membandingkan dua array data untuk menemukan perubahan spesifik.
     */
    private static function hitungPerbedaan(?array $lama, ?array $baru): ?array
    {
        if (!$lama || !$baru) return null;

        $perbedaan = [];
        foreach ($baru as $kunci => $nilai) {
            if (array_key_exists($kunci, $lama) && $lama[$kunci] != $nilai) {
                $perbedaan[$kunci] = [
                    'dari' => $lama[$kunci],
                    'menjadi' => $nilai
                ];
            }
        }

        return count($perbedaan) > 0 ? $perbedaan : null;
    }
}
