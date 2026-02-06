<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

/**
 * Class BangunDokumentasiSistem
 * Tujuan: Membangun dokumentasi teknis otomatis dalam format JSON.
 * Peran: Menjaga transparansi fitur dan struktur sistem hulu-ke-hilir.
 */
class BangunDokumentasiSistem extends Command
{
    /**
     * @var string
     */
    protected $signature = 'dokumentasi:generate';

    /**
     * @var string
     */
    protected $description = 'Membangun dokumentasi sistem Teqara otomatis dalam Bahasa Indonesia.';

    /**
     * Eksekusi perintah dokumentasi.
     */
    public function handle()
    {
        $this->info('Memulai pemetaan arsitektur sistem Teqara...');

        $jalurSimpan = storage_path('dokumentasi');
        if (!File::exists($jalurSimpan)) {
            File::makeDirectory($jalurSimpan, 0755, true);
        }

        $dokumentasi = [
            'nama_sistem' => 'SISTEM PENJUALAN TEQARA ENTERPRISE',
            'versi' => '16.0 (Laravel 12 + Livewire 4)',
            'bahasa' => '100% Bahasa Indonesia',
            'tanggal_generate' => now()->translatedFormat('l, d F Y H:i:s'),
            
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

            'arsitektur_database' => $this->petakanDatabase(),
            
            'status_sistem' => [
                'arsitektur' => 'SPA (One Page Application)',
                'modal_usage' => '0% (Strictly Forbidden)',
                'bahasa_inggris' => '0% (Strictly Forbidden)',
            ]
        ];

        File::put($jalurSimpan . '/dokumentasi_sistem.json', json_encode($dokumentasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('Dokumentasi berhasil dibangun di: storage/dokumentasi/dokumentasi_sistem.json');
    }

    /**
     * Memetakan seluruh tabel dan kolom database.
     */
    private function petakanDatabase()
    {
        $tabel = [];
        // Kita hanya ambil tabel bisnis utama untuk ringkasan dokumentasi
        $daftarTabel = ['pengguna', 'produk', 'pesanan', 'detail_pesanan', 'kategori', 'merek', 'log_aktivitas', 'pemasok', 'karyawan', 'tiket_bantuan', 'ulasan', 'voucher'];

        foreach ($daftarTabel as $namaTabel) {
            if (Schema::hasTable($namaTabel)) {
                $tabel[$namaTabel] = Schema::getColumnListing($namaTabel);
            }
        }

        return $tabel;
    }
}