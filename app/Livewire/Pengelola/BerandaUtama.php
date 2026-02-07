<?php

namespace App\Livewire\Pengelola;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Pengguna;
use App\Models\TransaksiPembayaran;
use App\Models\TiketBantuan;
use App\Models\Pemasok;
use App\Models\Karyawan;
use App\Models\LogAktivitas;
use App\Models\InsidenKeamanan;
use App\Models\PesananLogistik;
use App\Models\StokGudang;
use App\Models\Berita;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard Utama Pengelola (Executive Dashboard)
 * 
 * Bertanggung jawab mengumpulkan dan menampilkan seluruh statistik 
 * dari seluruh pilar manajemen Business Enterprise secara real-time.
 */
class BerandaUtama extends Component
{
    public function getStatistikProperti()
    {
        return [
            // 1. MANAJEMEN TRANSAKSI & KEUANGAN
            'pendapatan_hari_ini' => TransaksiPembayaran::whereDate('dibuat_pada', now())->where('status', 'sukses')->sum('jumlah_bayar'),
            'pendapatan_bulan_ini' => TransaksiPembayaran::whereMonth('dibuat_pada', now()->month)->where('status', 'sukses')->sum('jumlah_bayar'),
            
            // 2. MANAJEMEN PESANAN
            'pesanan_menunggu' => Pesanan::where('status_pesanan', 'menunggu')->count(),
            'pesanan_proses' => Pesanan::where('status_pesanan', 'diproses')->count(),
            
            // 3. MANAJEMEN PRODUK & GADGET
            'total_produk' => Produk::count(),
            'stok_menipis' => Produk::where('stok', '<=', 5)->count(),
            
            // 4. MANAJEMEN PELANGGAN (CRM)
            'total_pelanggan' => Pengguna::where('peran', 'pelanggan')->count(),
            'pelanggan_baru_minggu_ini' => Pengguna::where('peran', 'pelanggan')->where('dibuat_pada', '>=', now()->subDays(7))->count(),
            
            // 5. MANAJEMEN VENDOR
            'total_vendor' => Pemasok::count(),
            
            // 6. MANAJEMEN PEGAWAI (HRD)
            'total_karyawan' => Karyawan::count(),
            
            // 7. MANAJEMEN CUSTOMER SERVICE
            'tiket_terbuka' => TiketBantuan::whereIn('status', ['baru', 'terbuka'])->count(),
            
            // 8. MANAJEMEN LOGISTIK
            'pengiriman_berjalan' => 0, // Tabel pesanan_logistik belum diimplementasikan
            
            // 9. MANAJEMEN KEAMANAN SIBER
            'insiden_keamanan' => InsidenKeamanan::count(),
            'skor_risiko' => $this->hitungSkorRisikoSistem(),
            
            // 10. MANAJEMEN HALAMAN TOKO (CMS)
            'total_berita' => Berita::count(),
            
            // 11. SISTEM & AUDIT
            'aktivitas_hari_ini' => LogAktivitas::whereDate('waktu', now())->count(),
        ];
    }

    /**
     * Menghitung skor risiko sistem berdasarkan insiden dan aktivitas mencurigakan.
     * Skala 0 - 100 (Semakin rendah semakin aman).
     */
    private function hitungSkorRisikoSistem(): int
    {
        $insidenKritis = InsidenKeamanan::where('tingkat_keparahan', 'kritis')->count();
        $insidenTinggi = InsidenKeamanan::where('tingkat_keparahan', 'tinggi')->count();
        
        $skor = ($insidenKritis * 20) + ($insidenTinggi * 10);
        return min(100, $skor);
    }

    public function getPesananTerbaruProperti()
    {
        return Pesanan::with('pengguna')
            ->latest('dibuat_pada')
            ->take(8)
            ->get();
    }

    public function getLogTerbaruProperti()
    {
        return LogAktivitas::latest('waktu')
            ->take(10)
            ->get();
    }

    #[Title('Dashboard Eksekutif Business Enterprise - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.beranda-utama', [
            'statistik' => $this->getStatistikProperti(),
            'pesananTerbaru' => $this->getPesananTerbaruProperti(),
            'logTerbaru' => $this->getLogTerbaruProperti(),
        ])->layout('components.layouts.admin', ['header' => 'Dashboard Eksekutif']);
    }
}
