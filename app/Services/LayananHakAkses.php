<?php

namespace App\Services;

use App\Models\HakAkses;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Layanan Sinkronisasi Hak Akses Dinamis
 * 
 * Bertanggung jawab untuk memindai seluruh rute pengelola dan 
 * memastikan pilihan hak akses di modul SDM selalu diperbarui secara otomatis.
 */
class LayananHakAkses
{
    /**
     * Memindai rute dan menyinkronkan dengan tabel hak_akses.
     */
    public function sinkronkan(): array
    {
        $rutePengelola = collect(Route::getRoutes())->filter(function ($rute) {
            return str_starts_with($rute->getName(), 'pengelola.');
        });

        $statistik = ['baru' => 0, 'total' => 0];

        foreach ($rutePengelola as $rute) {
            $namaRute = $rute->getName();
            
            // Pemetaan Grup Modul Berdasarkan Struktur URL/Nama Rute
            $grupModul = $this->tentukanGrupModul($namaRute);
            
            // Format Nama Fitur yang Manusiawi
            $namaFitur = $this->formatNamaFitur($namaRute);

            $akses = HakAkses::updateOrCreate(
                ['kode_rute' => $namaRute],
                [
                    'nama_fitur' => $namaFitur,
                    'grup_modul' => $grupModul,
                ]
            );

            if ($akses->wasRecentlyCreated) {
                $statistik['baru']++;
            }
            $statistik['total']++;
        }

        // Hapus hak akses yang rutenya sudah tidak ada (Clean up)
        $daftarRuteAktif = $rutePengelola->pluck('name')->toArray();
        HakAkses::whereNotIn('kode_rute', $daftarRuteAktif)->delete();

        return $statistik;
    }

    /**
     * Logika pemetaan rute ke 13 pilar manajemen.
     */
    private function tentukanGrupModul(string $namaRute): string
    {
        $bagian = explode('.', $namaRute);
        $identitas = $bagian[1] ?? 'umum';

        return match ($identitas) {
            'toko' => 'Halaman Toko (CMS)',
            'produk', 'kategori', 'merek' => 'Produk & Inventaris',
            'pesanan' => 'Operasional Pesanan',
            'transaksi' => 'Keuangan & Transaksi',
            'cs', 'tiket' => 'Layanan Pelanggan',
            'logistik' => 'Logistik Pengiriman',
            'pelanggan' => 'Manajemen Member',
            'vendor' => 'Rantai Pasok (Vendor)',
            'hrd', 'pengguna' => 'SDM & Pegawai',
            'laporan' => 'Laporan & Analitik',
            'sistem', 'voucher' => 'Sistem Terpusat',
            'api' => 'Integrasi API',
            'keamanan' => 'Keamanan Siber (SOC)',
            default => 'Umum/Lainnya'
        };
    }

    /**
     * Mengubah kode rute menjadi nama fitur yang mudah dibaca.
     */
    private function formatNamaFitur(string $namaRute): string
    {
        // Hilangkan prefix 'pengelola.'
        $bersih = str_replace('pengelola.', '', $namaRute);
        
        // Ubah titik dan dash menjadi spasi, lalu Title Case
        $nama = Str::title(str_replace(['.', '-'], ' ', $bersih));

        // Penyesuaian kata khusus
        return str_replace(
            ['Cms', 'Hrd', 'Soc', 'Rfq', 'Pos'], 
            ['CMS', 'HRD', 'SOC', 'RFQ', 'POS'], 
            $nama
        );
    }
}
