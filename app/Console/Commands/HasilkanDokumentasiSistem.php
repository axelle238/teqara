<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LayananDokumentasi;

class HasilkanDokumentasiSistem extends Command
{
    /**
     * Nama dan tanda tangan dari command konsol.
     *
     * @var string
     */
    protected $signature = 'dokumentasi:generate';

    /**
     * Deskripsi dari command konsol.
     *
     * @var string
     */
    protected $description = 'Menghasilkan file dokumentasi_sistem.json secara otomatis';

    /**
     * Eksekusi command konsol.
     */
    public function handle(LayananDokumentasi $layanan)
    {
        $this->info('Sedang menghasilkan dokumentasi sistem Teqara...');
        
        try {
            $data = $layanan->hasilkanDokumentasi();
            
            $this->info('Dokumentasi berhasil diperbarui!');
            $this->table(['Kategori', 'Jumlah'], [
                ['Modul Aktif', count($data['modul_aktif'])],
                ['Endpoint Terdaftar', count($data['daftar_endpoint'])],
                ['Tabel Database', count($data['struktur_database'])],
            ]);
            
            $this->comment('Lokasi: storage/dokumentasi/dokumentasi_sistem.json');
        } catch (\Exception $e) {
            $this->error('Gagal menghasilkan dokumentasi: ' . $e->getMessage());
        }
    }
}
