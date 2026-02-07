<?php

namespace App\Console\Commands;

use App\Services\LayananDokumentasi;
use Illuminate\Console\Command;

class BuatDokumentasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dokumentasi:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dokumentasi sistem TEQARA otomatis ke JSON';

    /**
     * Execute the console command.
     */
    public function handle(LayananDokumentasi $layanan)
    {
        $this->info('Memulai generasi dokumentasi sistem...');
        
        try {
            $layanan->perbaruiDokumentasi();
            $this->info('Dokumentasi berhasil diperbarui di: storage/dokumentasi/dokumentasi_sistem.json');
        } catch (\Exception $e) {
            $this->error('Gagal membuat dokumentasi: ' . $e->getMessage());
        }
    }
}
