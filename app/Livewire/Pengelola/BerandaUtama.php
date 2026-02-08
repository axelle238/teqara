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
use App\Models\Berita;
use App\Models\KunciApi;
use App\Models\Voucher;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

/**
 * Dasbor Utama Pengelola (Panel Eksekutif)
 * 
 * Pusat monitoring 15 pilar manajemen Business Enterprise TEQARA.
 * Menyajikan statistik real-time, grafik tren, dan audit trail terbaru.
 */
class BerandaUtama extends Component
{
    /**
     * Data untuk Grafik Performa (ApexCharts)
     */
    public function getDataGrafikProperty()
    {
        $hari = collect([]);
        $omzet = collect([]);
        $pesanan = collect([]);

        for ($i = 6; $i >= 0; $i--) {
            $tgl = now()->subDays($i);
            $hari->push($tgl->translatedFormat('D'));
            
            $omzet->push(TransaksiPembayaran::whereDate('waktu_bayar', $tgl)
                ->where('status', 'sukses')
                ->sum('jumlah_bayar'));
                
            $pesanan->push(Pesanan::whereDate('dibuat_pada', $tgl)->count());
        }

        return [
            'label' => $hari,
            'omzet' => $omzet,
            'pesanan' => $pesanan,
        ];
    }

    /**
     * Mengambil statistik terkonsolidasi dari seluruh modul.
     */
    public function getStatistikProperty()
    {
        return [
            // 1. MANAJEMEN HALAMAN TOKO
            'total_artikel' => Berita::count(),
            'total_konten_halaman' => DB::table('konten_halaman')->count(),

            // 2. MANAJEMEN PRODUK & GADGET
            'total_produk' => Produk::count(),
            'stok_kritis' => Produk::where('stok', '<=', 5)->count(),
            
            // 3. MANAJEMEN PESANAN
            'pesanan_baru' => Pesanan::where('status_pesanan', 'menunggu')->count(),
            'pesanan_proses' => Pesanan::where('status_pesanan', 'diproses')->count(),
            
            // 4. MANAJEMEN TRANSAKSI
            'pendapatan_hari_ini' => TransaksiPembayaran::whereDate('waktu_bayar', now())->where('status', 'sukses')->sum('jumlah_bayar'),
            'total_transaksi_bulan_ini' => TransaksiPembayaran::whereMonth('waktu_bayar', now()->month)->where('status', 'sukses')->count(),
            
            // 5. MANAJEMEN CUSTOMER SERVICE
            'tiket_aktif' => TiketBantuan::whereIn('status', ['baru', 'terbuka', 'menunggu_pelanggan'])->count(),
            
            // 6. MANAJEMEN LOGISTIK PENGIRIMAN
            'pengiriman_berjalan' => Pesanan::where('status_pesanan', 'dikirim')->count(),
            
            // 7. MANAJEMEN PELANGGAN
            'total_pelanggan' => Pengguna::where('peran', 'pelanggan')->count(),
            
            // 8. MANAJEMEN VENDOR
            'total_mitra_vendor' => Pemasok::count(),
            
            // 9. MANAJEMEN PEGAWAI & PERAN
            'total_staf' => Karyawan::count(),
            
            // 10. MANAJEMEN LAPORAN & ANALITIK
            'laporan_tersedia' => 15, 
            
            // 11. PENGATURAN SISTEM TERPUSAT
            'voucher_aktif' => Voucher::where('berlaku_sampai', '>', now())->count(),
            
            // 12. PENGATURAN API TERPUSAT
            'total_kunci_api' => KunciApi::count(),
            
            // 13. PENGATURAN KEAMANAN TERPUSAT
            'insiden_keamanan_24j' => InsidenKeamanan::where('dibuat_pada', '>=', now()->subDay())->count(),
            'skor_keamanan' => $this->hitungSkorKeamanan(),
        ];
    }

    /**
     * Hitung skor keamanan sistem (0-100).
     */
    private function hitungSkorKeamanan(): int
    {
        $insiden = InsidenKeamanan::where('dibuat_pada', '>=', now()->subWeek())->count();
        $skor = 100 - ($insiden * 5);
        return max(0, $skor);
    }

    /**
     * Mengambil pesanan terbaru dan audit log terbaru.
     */
    public function getPesananTerbaruProperty()
    {
        return Pesanan::with('pengguna')->latest('dibuat_pada')->take(6)->get();
    }

    public function getLogAktivitasProperty()
    {
        return LogAktivitas::with('pengguna')->latest('waktu')->take(10)->get();
    }

    #[Title('Dasbor Eksekutif TEQARA - Enterprise System')]
    public function render()
    {
        return view('livewire.pengelola.beranda-utama')
            ->layout('components.layouts.admin', ['header' => 'Panel Eksekutif']);
    }
}