<?php

namespace App\Console\Commands;

use App\Services\LayananHakAkses;
use Illuminate\Console\Command;

/**
 * Command Sinkronisasi Hak Akses
 * 
 * Menjalankan pemindaian rute sistem dan mendaftarkannya ke tabel hak_akses.
 */
class SinkronisasiHakAkses extends Command
{
    /**
     * Nama dan tanda tangan perintah console.
     */
    protected $signature = 'sistem:sinkron-akses';

    /**
     * Deskripsi perintah console.
     */
    protected $description = 'Sinkronisasi otomatis rute pengelola ke tabel hak_akses';

    /**
     * Jalankan perintah console.
     */
    public function handle(LayananHakAkses $layanan)
    {
        $this->info('Memulai sinkronisasi fitur dan fungsi sistem...');
        
        $hasil = $layanan->sinkronkan();

        $this->table(['Kategori', 'Jumlah'], [
            ['Total Fitur Terdaftar', $hasil['total']],
            ['Fitur Baru Ditemukan', $hasil['baru']],
        ]);

        $this->info('Sinkronisasi hak akses selesai.');
    }
}