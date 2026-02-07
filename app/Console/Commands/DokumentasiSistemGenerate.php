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
        $this->info('Sedang mengumpulkan metadata sistem...');

        $dokumentasi = [
            'nama_sistem' => 'TEQARA Business Enterprise Store',
            'versi' => '16.0 (Enterprise)',
            'terakhir_diupdate' => now()->toIso8601String(),
            'status_server' => 'Online',
            
            'modul_aktif' => [
                'Manajemen Produk' => 'Hulu ke Hilir (ERP Standard)',
                'Manajemen Pesanan' => 'POS & Online Transaction',
                'Transaksi Keuangan' => 'Automated Ledger & Payout',
                'Keamanan Siber' => 'SOC Dashboard & WAF',
                'SDM & HRD' => 'Employee Lifecycle & Payroll',
                'Logistik' => 'RajaOngkir & Courier Sync',
                'Layanan Bantuan' => 'Customer Support Ticketing',
                'API & Integrasi' => 'Internal & External Gateway',
            ],

            'struktur_basis_data' => $this->getDatabaseSummary(),
            
            'fitur_unggulan' => [
                'SPA Navigation' => 'Real-time update tanpa refresh halaman.',
                'Enterprise Dashboard' => 'Visualisasi data mendalam untuk eksekutif.',
                'Zero Trust Security' => 'Implementasi keamanan berlapis pada setiap endpoint.',
                'Automated SEO' => 'Slug dan metadata otomatis Bahasa Indonesia.',
            ]
        ];

        $path = storage_path('dokumentasi');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        File::put($path . '/dokumentasi_sistem.json', json_encode($dokumentasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('Dokumentasi sistem berhasil dihasilkan di: ' . $path . '/dokumentasi_sistem.json');
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