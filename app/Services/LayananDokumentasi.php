<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
            'nama_sistem' => 'TEQARA Enterprise v2.0',
            'deskripsi' => 'Platform Penjualan Komputer & Gadget Terintegrasi',
            'versi_laravel' => app()->version(),
            'bahasa_sistem' => '100% Bahasa Indonesia',
            'status_arsitektur' => 'SPA (Single Page Application) via Livewire',
            'kebijakan_ui' => '0% Modal (Mutlak)',
            'waktu_pembaruan_terakhir' => now()->format('d/m/Y H:i:s'),
            
            'statistik_data' => $this->ambilStatistikDatabase(),
            'modul_aktif' => [
                'Hulu' => ['Manajemen Produk Kompleks', 'Varian SKU', 'Gudang Multi-Lokasi', 'Pelacakan Nomor Seri', 'Stok & Gudang'],
                'Tengah' => ['Katalog Spotlight', 'Detail Produk Rich-Media', 'Keranjang Persisten', 'Voucher Promo'],
                'Hilir' => ['Checkout Multiproses', 'Gateway Pembayaran Simulasi', 'Timeline Pelacakan', 'Audit Log Naratif', 'Analitik Eksekutif'],
            ],
            'daftar_endpoint' => $this->ambilDaftarRute(),
        ];

        $jalurSimpan = storage_path('dokumentasi/dokumentasi_sistem.json');
        
        if (!File::exists(dirname($jalurSimpan))) {
            File::makeDirectory(dirname($jalurSimpan), 0755, true);
        }

        File::put($jalurSimpan, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Mengambil jumlah data dari tabel-tabel utama.
     */
    private function ambilStatistikDatabase(): array
    {
        $tabelTarget = ['pengguna', 'produk', 'pesanan', 'log_aktivitas', 'voucher', 'ulasan'];
        $hasil = [];

        foreach ($tabelTarget as $tabel) {
            if (Schema::hasTable($tabel)) {
                $hasil[$tabel] = DB::table($tabel)->count();
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
        })->filter(fn($r) => !str_starts_with($r['uri'], '_'))
          ->values()
          ->toArray();
    }
}
