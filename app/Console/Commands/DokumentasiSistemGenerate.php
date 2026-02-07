<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

/**
 * Class DokumentasiSistemGenerate
 * Tujuan: Menghasilkan dokumentasi hidup sistem TEQARA dalam format JSON.
 */
class DokumentasiSistemGenerate extends Command
{
    protected $signature = 'dokumentasi:generate';
    protected $description = 'Menghasilkan dokumentasi hidup sistem TEQARA dalam format JSON';

    public function handle()
    {
        $this->info('Sedang menghasilkan dokumentasi sistem Teqara...');

        $dokumentasi = [
            'identitas' => [
                'nama' => 'TEQARA Enterprise Commerce',
                'versi' => '16.0.0-Paripurna',
                'bahasa' => '100% Bahasa Indonesia',
                'waktu_generate' => now()->translatedFormat('l, d F Y H:i:s'),
            ],
            
            'statistik_sistem' => [
                'total_modul' => 15,
                'total_endpoint' => count(\Illuminate\Support\Facades\Route::getRoutes()),
                'total_tabel_db' => count($this->getDatabaseSummary()),
                'total_produk_aktif' => \App\Models\Produk::where('status', 'aktif')->count(),
            ],

            'arsitektur' => [
                'backend' => 'Laravel 12 (Modern)',
                'frontend' => 'Livewire 4 + Alpine.js',
                'interaksi' => 'One Page Application (SPA)',
                'modal_policy' => 'Dilarang (100% Inline/Section)',
            ],

            'daftar_tabel' => $this->getDatabaseSummary(),
        ];

        $jalur = storage_path('dokumentasi');
        if (!File::exists($jalur)) {
            File::makeDirectory($jalur, 0755, true);
        }

        File::put($jalur . '/dokumentasi_sistem.json', json_encode($dokumentasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('Dokumentasi berhasil diperbarui!');
        $this->table(['Kategori', 'Jumlah'], [
            ['Modul Aktif', $dokumentasi['statistik_sistem']['total_modul']],
            ['Endpoint Terdaftar', $dokumentasi['statistik_sistem']['total_endpoint']],
            ['Tabel Database', $dokumentasi['statistik_sistem']['total_tabel_db']],
        ]);
        $this->info('Lokasi: storage/dokumentasi/dokumentasi_sistem.json');
    }

    private function getDatabaseSummary()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $tableNameKey = 'Tables_in_' . env('DB_DATABASE');
            
            return collect($tables)->map(function ($table) use ($tableNameKey) {
                return $table->$tableNameKey;
            })->values()->all();
        } catch (\Exception $e) {
            return ['Gagal mengambil daftar tabel: ' . $e->getMessage()];
        }
    }
}