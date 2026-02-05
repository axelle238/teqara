<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/**
 * LayananDokumentasi
 * Tujuan: Menghasilkan dokumentasi sistem TEQARA secara otomatis dalam format JSON.
 * Peran: Memastikan transparansi struktur sistem setiap saat sesuai standar v16.0.
 */
class LayananDokumentasi
{
    /**
     * Hasilkan file dokumentasi JSON terbaru.
     */
    public function perbaruiDokumentasi(): void
    {
        $data = [
            'nama_sistem' => 'TEQARA Enterprise Hub v16.0',
            'deskripsi' => 'Ekosistem Kendali Komputasi & Gadget Enterprise',
            'versi_laravel' => '12.0',
            'bahasa_sistem' => '100% Bahasa Indonesia (Nasionalisasi Mutlak)',
            'arsitektur' => [
                'backend' => 'Laravel 12 (Core)',
                'frontend' => 'Livewire 4 + Tailwind CSS 4',
                'pola_interaksi' => 'SPA / Real-time Events',
                'kebijakan_modal' => '0% Modal (Ganti Panel Geser)',
                'kebijakan_warna' => 'Vibrant High-Tech (No Dark/Black Policy)',
            ],
            'waktu_pembaruan_terakhir' => now()->format('d/m/Y H:i:s'),

            'statistik_data' => $this->ambilStatistikDatabase(),
            'sebelas_pilar_manajemen' => [
                'Pilar 1' => 'Manajemen Halaman Toko (Konten & Berita)',
                'Pilar 2' => 'Manajemen Produk & Gadget (Katalog & Stok)',
                'Pilar 3' => 'Manajemen Pesanan (Antrian Transaksi)',
                'Pilar 4' => 'Manajemen Transaksi & Finansial (Arus Kas)',
                'Pilar 5' => 'Manajemen Layanan Pelanggan (Helpdesk Tiket)',
                'Pilar 6' => 'Manajemen Logistik & Pengiriman (Mitra Pemasok)',
                'Pilar 7' => 'Manajemen Pelanggan (CRM Member)',
                'Pilar 8' => 'Manajemen Pegawai & Peran (SDM Organisasi)',
                'Pilar 9' => 'Manajemen Laporan & Analitik (Profit)',
                'Pilar 10' => 'Pengaturan Sistem Terpusat (Identitas & Promo)',
                'Pilar 11' => 'Pengaturan Keamanan Terpusat (Radar Audit)',
            ],
            'daftar_endpoint' => $this->ambilDaftarRute(),
        ];

        $jalurSimpan = storage_path('dokumentasi/dokumentasi_sistem.json');

        if (! File::exists(dirname($jalurSimpan))) {
            File::makeDirectory(dirname($jalurSimpan), 0755, true);
        }

        File::put($jalurSimpan, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function ambilStatistikDatabase(): array
    {
        $tabelTarget = [
            'pengguna', 'produk', 'pesanan', 'log_aktivitas', 'voucher',
            'ulasan', 'gudang', 'pemasok', 'karyawan', 'mutasi_stok',
        ];
        $hasil = [];

        foreach ($tabelTarget as $tabel) {
            try {
                if (Schema::hasTable($tabel)) {
                    $hasil[$tabel] = DB::table($tabel)->count();
                }
            } catch (\Exception $e) {
                // Abaikan
            }
        }

        return $hasil;
    }

    private function ambilDaftarRute(): array
    {
        return collect(Route::getRoutes())->map(function ($rute) {
            return [
                'uri' => $rute->uri(),
                'nama' => $rute->getName(),
                'metode' => implode('|', $rute->methods()),
            ];
        })->filter(fn ($r) => ! str_starts_with($r['uri'], '_'))
            ->values()
            ->toArray();
    }
}
