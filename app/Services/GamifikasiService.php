<?php

namespace App\Services;

use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;

class GamifikasiService
{
    /**
     * Tambah poin ke pengguna.
     */
    public function tambahPoin(Pengguna $user, int $jumlah, string $sumber, ?string $ref = null)
    {
        DB::transaction(function () use ($user, $jumlah, $sumber, $ref) {
            $user->increment('poin_loyalitas', $jumlah);

            DB::table('riwayat_poin')->insert([
                'pengguna_id' => $user->id,
                'jumlah' => $jumlah,
                'sumber' => $sumber,
                'referensi_id' => $ref,
                'keterangan' => "Poin masuk dari $sumber",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->cekLevelUp($user);
        });
    }

    /**
     * Cek apakah user berhak naik level.
     */
    public function cekLevelUp(Pengguna $user)
    {
        $poin = $user->poin_loyalitas;
        $levelBaru = 'Classic';

        if ($poin >= 10000) {
            $levelBaru = 'Platinum';
        } elseif ($poin >= 5000) {
            $levelBaru = 'Gold';
        } elseif ($poin >= 1000) {
            $levelBaru = 'Silver';
        }

        if ($user->level_member !== $levelBaru) {
            $user->update(['level_member' => $levelBaru]);

            // Log Level Up (Opsional: Kirim Notifikasi)
            \App\Helpers\LogHelper::catat('level_up', $user->nama, "Selamat! Anda naik ke level $levelBaru");
        }
    }
}
