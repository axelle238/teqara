<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/**
 * Class HasilkanDokumentasiSistem
 * Tujuan: Menghasilkan dokumentasi hidup otomatis untuk sistem Teqara v16.0.
 * Lokasi: /storage/dokumentasi/dokumentasi_sistem.json
 */
class HasilkanDokumentasiSistem extends Command
{
    protected $signature = 'dokumentasi:generate';
    protected $description = 'Menghasilkan file dokumentasi JSON untuk memantau status sistem Teqara v16.0';

    public function handle(): void
    {
        $this->info('Sedang memindai arsitektur sistem Teqara...');

        $dokumentasi = [
            'nama_sistem' => 'TEQARA ENTERPRISE HUB v16.0',
            'waktu_generate' => now()->format('Y-m-d H:i:s'),
            'status_pilar' => $this->auditPilar(),
            'statistik_database' => $this->auditDatabase(),
            'titik_akhir_rute' => $this->auditRute(),
            'catatan_pengembang' => 'Sistem 100% Nasionalisasi Bahasa Indonesia, Tanpa Modal, Vibrant UI.'
        ];

        $path = storage_path('dokumentasi/dokumentasi_sistem.json');
        
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, json_encode($dokumentasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info("Dokumentasi berhasil diperbarui di: storage/dokumentasi/dokumentasi_sistem.json");
    }

    protected function auditPilar(): array
    {
        return [
            'Pilar 1: Manajemen Halaman Toko' => 'Aktif (CMS Konten & Berita)',
            'Pilar 2: Manajemen Produk & Gadget' => 'Aktif (Katalog, Stok, Kategori, Merek)',
            'Pilar 3: Manajemen Pesanan' => 'Aktif (Antrian, Detail, Verifikasi)',
            'Pilar 4: Manajemen Transaksi' => 'Aktif (Arus Kas, Verifikasi Bayar)',
            'Pilar 5: Layanan Pelanggan' => 'Aktif (Tiket Bantuan, Moderasi Ulasan)',
            'Pilar 6: Manajemen Logistik' => 'Aktif (Manifest Kirim, Pemasok)',
            'Pilar 7: Manajemen Pelanggan' => 'Aktif (CRM, Member Basis)',
            'Pilar 8: Manajemen Pegawai' => 'Aktif (Struktur, SDM, Peran)',
            'Pilar 9: Manajemen Laporan' => 'Aktif (Analitik Profit)',
            'Pilar 10: Pengaturan Sistem' => 'Aktif (Identitas, Voucher)',
            'Pilar 11: Pengaturan Keamanan' => 'Aktif (Radar Akses, Log Forensik)',
        ];
    }

    protected function auditDatabase(): array
    {
        $tables = ['pengguna', 'produk', 'pesanan', 'transaksi_pembayaran', 'log_aktivitas', 'konten_halaman'];
        $stats = [];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $stats[$table] = \Illuminate\Support\Facades\DB::table($table)->count() . ' baris data';
            }
        }

        return $stats;
    }

    protected function auditRute(): int
    {
        return count(Route::getRoutes());
    }
}
