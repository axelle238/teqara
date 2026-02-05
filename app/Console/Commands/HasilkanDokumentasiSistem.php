<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HasilkanDokumentasiSistem extends Command
{
    /**
     * Nama dan tanda perintah konsol.
     *
     * @var string
     */
    protected $signature = 'dokumentasi:generate';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Menghasilkan dokumentasi sistem TEQARA otomatis dalam format JSON';

    /**
     * Jalankan perintah konsol.
     */
    public function handle()
    {
        $this->info('Sedang mengumpulkan data sistem TEQARA...');

        $data = [
            'nama_sistem' => 'TEQARA - Sistem Penjualan Komputer & Gadget',
            'versi_laravel' => app()->version(),
            'bahasa_sistem' => '100% Bahasa Indonesia',
            'terakhir_diperbarui' => now()->format('d/m/Y H:i:s'),
            
            'modul_aktif' => [
                'Hulu' => ['Manajemen Produk', 'Kategori', 'Merek', 'Manajemen Stok'],
                'Tengah' => ['Katalog Publik', 'Detail Produk', 'Keranjang Belanja', 'Checkout'],
                'Hilir' => ['Manajemen Pesanan', 'Status Transaksi', 'Riwayat Pesanan', 'Audit Log'],
            ],

            'struktur_database' => $this->ambilStrukturDatabase(),
            
            'endpoint_sistem' => $this->ambilDaftarEndpoint(),

            'status_keamanan' => [
                'Middleware' => ['auth', 'CekPeranAdmin'],
                'Akses_Modal' => 'DILARANG (0% Modal)',
            ]
        ];

        $path = storage_path('dokumentasi/dokumentasi_sistem.json');
        
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info("Dokumentasi berhasil disimpan di: $path");
    }

    private function ambilStrukturDatabase()
    {
        $tabelWajib = ['pengguna', 'produk', 'kategori', 'merek', 'pesanan', 'detail_pesanan', 'log_aktivitas'];
        $hasil = [];

        foreach ($tabelWajib as $tabel) {
            if (Schema::hasTable($tabel)) {
                $hasil[$tabel] = [
                    'jumlah_baris' => DB::table($tabel)->count(),
                    'status' => 'Aktif'
                ];
            }
        }

        return $hasil;
    }

    private function ambilDaftarEndpoint()
    {
        return collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'nama' => $route->getName(),
                'method' => implode('|', $route->methods()),
            ];
        })->filter(fn($r) => str_contains($r['uri'], 'admin') || $r['nama'] !== null)
          ->values()
          ->toArray();
    }
}