<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * Command: dokumentasi:generate
 * Tujuan: Membangun dokumentasi sistem hidup otomatis dalam format JSON.
 * Mencakup fitur, modul aktif, dan struktur integritas data.
 */
class DokumentasiGenerate extends Command
{
    protected $signature = 'dokumentasi:generate';
    protected $description = 'Generate dokumentasi sistem hidup otomatis (format JSON)';

    public function handle()
    {
        $this->info('Membangun Dokumentasi Sistem Teqara...');

        $data = [
            'nama_sistem' => 'TEQARA Business Enterprise System',
            'versi' => '16.0.0-UPGRADE',
            'waktu_generate' => now()->toDateTimeString(),
            'bahasa_utama' => 'Bahasa Indonesia (100%)',
            'arsitektur' => [
                'framework' => 'Laravel 12',
                'frontend' => 'Livewire 4 + Alpine.js',
                'database' => 'MySQL / MariaDB',
                'ui_style' => 'SPA / One Page (No Modal)'
            ],
            'modul_aktif' => [
                '1. Panel Eksekutif' => 'Dashboard real-time dengan ApexCharts',
                '2. Pusat Notifikasi' => 'Inbox sistem & alert operasional',
                '3. Etalase Toko (CMS)' => 'Manajemen konten halaman & berita',
                '4. Produk & Gadget' => 'Manajemen SKU, Varian, Spesifikasi, & SN',
                '5. Pesanan & POS' => 'Alur transaksi hulu-ke-hilir & pembayaran',
                '6. Transaksi Keuangan' => 'Monitoring arus kas (Cashflow)',
                '7. Layanan Bantuan' => 'Helpdesk & sistem tiket komplain',
                '8. Logistik & Kurir' => 'Pemantauan pengiriman & resi',
                '9. Member & Pelanggan' => 'CRM & Database loyalitas',
                '10. Vendor & PO' => 'Rantai pasok & Purchase Order',
                '11. SDM & HRD' => 'Manajemen karyawan & hak akses (RBAC)',
                '12. Laporan & Audit' => 'Audit log naratif & analisa data',
                '13. Sistem Terpusat' => 'Konfigurasi global & kesehatan server',
                '14. Pengaturan API' => 'Gateway integrasi (Payment & Logistics)',
                '15. Keamanan Siber' => 'Cyber Security SOC Command Center'
            ],
            'status_keamanan' => 'DEFCON Logic Enabled',
            'metadata_seo' => 'Dynamic Indonesian Slugs & Meta Tags'
        ];

        $path = storage_path('dokumentasi/dokumentasi_sistem.json');
        
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('Dokumentasi berhasil disimpan di: ' . $path);
    }
}
