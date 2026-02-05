<?php

namespace App\Services;

use App\Models\Pengguna;
use App\Models\RiwayatPoin;

/**
 * Class LayananGamifikasi
 * Tujuan: Manajemen loyalitas pelanggan melalui sistem poin dan level member.
 */
class LayananGamifikasi
{
    /**
     * Menambahkan poin ke akun pelanggan.
     */
    public function tambahPoin(Pengguna $pengguna, int $jumlah, $sumber, $referensiId = null)
    {
        $pengguna->increment('poin_loyalitas', $jumlah);

        RiwayatPoin::create([
            'pengguna_id' => $pengguna->id,
            'jumlah' => $jumlah,
            'sumber' => $sumber,
            'referensi_id' => $referensiId,
            'keterangan' => "Mendapatkan {$jumlah} poin dari {$sumber}",
        ]);

        $this->cekKenaikanLevel($pengguna);
    }

    /**
     * Mengevaluasi ambang batas poin untuk kenaikan level member.
     */
    private function cekKenaikanLevel(Pengguna $pengguna)
    {
        $poin = $pengguna->poin_loyalitas;
        $levelBaru = 'Classic';

        if ($poin >= 10000) {
            $levelBaru = 'Platinum';
        } elseif ($poin >= 5000) {
            $levelBaru = 'Gold';
        } elseif ($poin >= 1000) {
            $levelBaru = 'Silver';
        }

        if ($pengguna->level_member !== $levelBaru) {
            $pengguna->update(['level_member' => $levelBaru]);
        }
    }
}
