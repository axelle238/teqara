<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LayananDokumentasi;

class HasilkanDokumentasiSistem extends Command
{
    protected $signature = 'dokumentasi:generate';
    protected $description = 'Menghasilkan dokumentasi sistem TEQARA otomatis via Layanan';

    public function handle(LayananDokumentasi $layanan)
    {
        $this->info('Sedang memperbarui dokumentasi sistem...');
        $layanan->perbaruiDokumentasi();
        $this->info('Dokumentasi berhasil diperbarui di storage/dokumentasi/dokumentasi_sistem.json');
    }
}