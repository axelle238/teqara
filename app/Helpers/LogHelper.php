<?php

namespace App\Helpers;

use App\Models\LogAktivitas;

class LogHelper
{
    /**
     * Catat aktivitas baru ke database.
     *
     * @param  string  $aksi  Jenis aksi (create, update, delete, dll)
     * @param  string  $target  Objek yang dikenai aksi (Nama Produk, No Invoice)
     * @param  string  $pesan  Pesan naratif untuk manusia
     * @param  array|null  $meta  Data teknis tambahan (opsional)
     */
    public static function catat($aksi, $target, $pesan, $meta = null)
    {
        try {
            LogAktivitas::create([
                'pengguna_id' => auth()->id(), // Bisa null jika system action
                'aksi' => $aksi,
                'target' => $target,
                'pesan_naratif' => $pesan,
                'meta_data' => $meta,
                'waktu' => now(),
            ]);
        } catch (\Exception $e) {
            // Jangan biarkan log error menghentikan proses utama
            // Di produksi: log ke file laravel.log
        }
    }
}
