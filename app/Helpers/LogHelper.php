<?php

namespace App\Helpers;

use App\Models\LogAktivitas;

class LogHelper
{
    /**
     * Catat aktivitas baru ke database dengan metadata forensik.
     *
     * @param  string  $aksi  Jenis aksi (login, create, update, delete, dll)
     * @param  string  $target  Objek yang dikenai aksi
     * @param  string  $pesan  Pesan naratif untuk manusia
     * @param  array|null  $data  Tambahan snapshot data (opsional)
     */
    public static function catat($aksi, $target, $pesan, $data = null)
    {
        try {
            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi' => $aksi,
                'target' => $target,
                'pesan_naratif' => $pesan,
                'meta_data' => [
                    'alamat_ip' => request()->ip(),
                    'agen_pengguna' => request()->userAgent(),
                    'cuplikan_data' => $data,
                    'tautan' => request()->fullUrl(),
                    'metode' => request()->method(),
                ],
                'waktu' => now(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mencatat log aktivitas: '.$e->getMessage());
        }
    }
}
