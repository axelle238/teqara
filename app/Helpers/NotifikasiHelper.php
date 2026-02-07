<?php

namespace App\Helpers;

use App\Models\Notifikasi;

class NotifikasiHelper
{
    /**
     * Kirim notifikasi ke pengguna atau sistem.
     * 
     * @param string $judul
     * @param string $pesan
     * @param string $tipe (info, sukses, peringatan, bahaya)
     * @param int|null $penggunaId (null untuk broadcast/sistem)
     * @param string|null $tautan
     * @return Notifikasi
     */
    public static function kirim(string $judul, string $pesan, string $tipe = 'info', ?int $penggunaId = null, ?string $tautan = null)
    {
        return Notifikasi::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
            'tautan' => $tautan,
            'dibuat_pada' => now(),
        ]);
    }

    public static function sukses(string $judul, string $pesan, ?int $penggunaId = null, ?string $tautan = null)
    {
        return self::kirim($judul, $pesan, 'sukses', $penggunaId, $tautan);
    }

    public static function peringatan(string $judul, string $pesan, ?int $penggunaId = null, ?string $tautan = null)
    {
        return self::kirim($judul, $pesan, 'peringatan', $penggunaId, $tautan);
    }

    public static function bahaya(string $judul, string $pesan, ?int $penggunaId = null, ?string $tautan = null)
    {
        return self::kirim($judul, $pesan, 'bahaya', $penggunaId, $tautan);
    }
}