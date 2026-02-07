<?php

namespace App\Services;

use App\Models\HakAkses;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Layanan Sinkronisasi Hak Akses Otomatis
 * 
 * Memindai seluruh rute dengan awalan 'pengelola.' dan mendaftarkannya 
 * ke dalam tabel hak_akses untuk manajemen izin yang dinamis.
 */
class LayananHakAkses
{
    /**
     * Sinkronkan daftar rute pengelola ke tabel hak_akses.
     */
    public function sinkronkan(): array
    {
        $rutePengelola = collect(Route::getRoutes())->filter(function ($rute) {
            return str_starts_with($rute->getName(), 'pengelola.');
        });

        $statistik = ['baru' => 0, 'total' => 0];

        foreach ($rutePengelola as $rute) {
            $namaRute = $rute->getName();
            $bagian = explode('.', $namaRute);
            
            // Tentukan Grup Modul (Elemen kedua setelah 'pengelola')
            $grupModul = isset($bagian[1]) ? Str::title(str_replace('-', ' ', $bagian[1])) : 'Umum';
            
            // Nama Fitur (Format manusiawi dari sisa rute)
            $namaFitur = Str::title(str_replace(['.', '-'], ' ', str_replace('pengelola.', '', $namaRute)));

            $akses = HakAkses::updateOrCreate(
                ['kode_rute' => $namaRute],
                [
                    'nama_fitur' => $namaFitur,
                    'grup_modul' => $grupModul,
                ]
            );

            if ($akses->wasRecentlyCreated) {
                $statistik['baru']++;
            }
            $statistik['total']++;
        }

        return $statistik;
    }
}
