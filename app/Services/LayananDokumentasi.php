<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/**
 * LayananDokumentasi
 * Tujuan: Menghasilkan dokumentasi sistem TEQARA secara otomatis dalam format JSON.
 * Peran: Memastikan transparansi struktur sistem setiap saat.
 */
class LayananDokumentasi
{
    /**
     * Hasilkan file dokumentasi JSON terbaru.
     */
    public function perbaruiDokumentasi(): void
    {
        $data = [
            'nama_sistem' => 'TEQARA Enterprise v3.0',
            'deskripsi' => 'Ekosistem Penjualan Komputer & Gadget Enterprise Grade',
            'versi_laravel' => app()->version(),
            'bahasa_sistem' => '100% Bahasa Indonesia',
            'arsitektur' => [
                'backend' => 'Laravel 12 (Core)',
                'frontend' => 'Livewire 4 + Tailwind CSS 4',
                'pola_interaksi' => 'SPA / Real-time Events',
                'kebijakan_modal' => '0% Modal (Mutlak)',
            ],
            'waktu_pembaruan_terakhir' => now()->format('d/m/Y H:i:s'),

            'statistik_data' => $this->ambilStatistikDatabase(),
            'cakupan_bisnis' => [
                'Hulu (Supply Chain)' => [
                    'Manajemen Pemasok (Vendor Management)',
                    'Purchase Order (PO) Stok',
                    'Multi-Gudang & Stok Gudang',
                    'Mutasi & Audit Stok',
                    'Pelacakan Nomor Seri (Serial Number)',
                ],
                'Tengah (Customer Experience)' => [
                    'Katalog High-Tech Spotlight',
                    'Varian Produk Kompleks',
                    'Promo Flash Sale & Voucher',
                    'Keranjang Belanja Persisten',
                    'Checkout Multiproses Real-time',
                ],
                'Hilir (Operations & Analytics)' => [
                    'Manajemen Pengiriman (Tracking)',
                    'Audit Log Naratif (Activity Stream)',
                    'Dasbor Analitik Eksekutif',
                    'Manajemen HRD & Organisasi',
                    'Gamifikasi (Loyalty Points)',
                ],
            ],
            'daftar_endpoint' => $this->ambilDaftarRute(),
        ];

        $jalurSimpan = storage_path('dokumentasi/dokumentasi_sistem.json');

        if (! File::exists(dirname($jalurSimpan))) {
            File::makeDirectory(dirname($jalurSimpan), 0755, true);
        }

        File::put($jalurSimpan, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Mengambil jumlah data dari tabel-tabel utama.
     */
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
                // Abaikan jika error
            }
        }

        return $hasil;
    }

    /**
     * Mengambil daftar rute aplikasi yang terdaftar.
     */
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
