<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/**
 * Layanan Dokumentasi Sistem Otomatis
 * 
 * Bertanggung jawab menghasilkan dokumentasi teknis dalam format JSON
 * yang mencakup modul aktif, endpoint, dan struktur database secara real-time.
 */
class LayananDokumentasi
{
    /**
     * Menghasilkan file dokumentasi_sistem.json secara otomatis.
     */
    public function hasilkanDokumentasi(): array
    {
        // Jalankan sinkronisasi hak akses secara otomatis
        (new LayananHakAkses)->sinkronkan();

        $data = [
            'identitas_sistem' => [
                'nama' => 'TEQARA Business Enterprise Store',
                'versi' => '16.0.0-Paripurna',
                'bahasa' => '100% Bahasa Indonesia',
                'waktu_update' => now()->translatedFormat('l, d F Y H:i:s'),
            ],
            'arsitektur' => [
                'backend' => 'Laravel 12 (Modern)',
                'frontend' => 'Livewire 4 + Alpine.js',
                'interaksi' => 'One Page Application (SPA)',
                'modal_policy' => 'Dilarang (100% Inline/Section)',
            ],
            'status_sistem' => [
                'lingkungan' => config('app.env'),
                'debug_mode' => config('app.debug'),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
            ],
            'pilar_manajemen' => [
                'Manajemen Halaman Toko' => 'CMS dinamis untuk konten visual dan berita.',
                'Manajemen Produk & Gadget' => 'Kendali unit, kategori, merek, dan seri.',
                'Manajemen Pesanan' => 'Pemenuhan transaksi hulu ke hilir.',
                'Manajemen Transaksi' => 'Otoritas bayar, voucher, dan promo.',
                'Manajemen Customer Service' => 'Resolusi tiket dan ulasan pelanggan.',
                'Manajemen Logistik' => 'Rantai pasok dan data vendor.',
                'Manajemen Pelanggan' => 'CRM dan direktori member.',
                'Manajemen Pegawai' => 'Administrasi SDM dan struktur organisasi.',
                'Manajemen Laporan' => 'Analitik bisnis real-time.',
                'Pengaturan Sistem' => 'Konfigurasi identitas global.',
                'Pengaturan Keamanan' => 'Audit log dan enkripsi data.',
            ],
            'modul_aktif' => $this->ambilModulAktif(),
            'daftar_endpoint' => $this->ambilDaftarEndpoint(),
            'struktur_database' => $this->ambilStrukturDatabase(),
        ];

        $path = storage_path('dokumentasi/dokumentasi_sistem.json');
        
        // Pastikan direktori ada
        if (!File::exists(storage_path('dokumentasi'))) {
            File::makeDirectory(storage_path('dokumentasi'), 0755, true);
        }

        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $data;
    }

    /**
     * Alias untuk hasilkanDokumentasi() guna mendukung pembaharuan otomatis via Observer.
     */
    public function perbaruiDokumentasi(): void
    {
        $this->hasilkanDokumentasi();
    }

    /**
     * Mengambil daftar modul aktif berdasarkan folder Livewire.
     */
    private function ambilModulAktif(): array
    {
        $path = app_path('Livewire/Pengelola');
        if (!File::exists($path)) {
            return [];
        }

        $direktori = File::directories($path);
        $modul = [];

        foreach ($direktori as $dir) {
            $nama = basename($dir);
            $modul[] = [
                'nama' => str_replace('Manajemen', 'Manajemen ', $nama),
                'kode' => $nama,
                'jumlah_komponen' => count(File::files($dir)),
            ];
        }

        return $modul;
    }

    /**
     * Mengambil daftar route/endpoint yang terdaftar dalam sistem.
     */
    private function ambilDaftarEndpoint(): array
    {
        $routes = Route::getRoutes();
        $daftar = [];

        foreach ($routes as $route) {
            if (str_contains($route->getName(), 'pengelola.')) {
                $daftar[] = [
                    'nama' => $route->getName(),
                    'uri' => $route->uri(),
                    'metode' => $route->methods()[0],
                ];
            }
        }

        return $daftar;
    }

    /**
     * Mengambil ringkasan struktur database.
     */
    private function ambilStrukturDatabase(): array
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $key = "Tables_in_" . $dbName;
        
        $struktur = [];

        foreach ($tables as $table) {
            $tableName = $table->$key;
            $columns = DB::select("SHOW COLUMNS FROM $tableName");
            
            $daftarKolom = [];
            foreach ($columns as $column) {
                $daftarKolom[] = [
                    'nama' => $column->Field,
                    'tipe' => $column->Type,
                    'null' => $column->Null,
                    'kunci' => $column->Key,
                ];
            }

            $struktur[] = [
                'tabel' => $tableName,
                'kolom' => $daftarKolom,
            ];
        }

        return $struktur;
    }
}
