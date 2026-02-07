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
            'nama_sistem' => 'TEQARA Business Enterprise Store',
            'versi' => '12.0.0',
            'tanggal_update' => now()->format('Y-m-d H:i:s'),
            'status_sistem' => [
                'lingkungan' => config('app.env'),
                'debug_mode' => config('app.debug'),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
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