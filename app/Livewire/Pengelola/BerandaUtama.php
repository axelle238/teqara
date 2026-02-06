<?php

namespace App\Livewire\Pengelola;

use App\Models\Berita;
use App\Models\Karyawan;
use App\Models\KontenHalaman;
use App\Models\LogAktivitas;
use App\Models\Pemasok;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\TiketBantuan;
use App\Models\Ulasan;
use App\Models\Voucher;
use App\Models\TransaksiPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaUtama
 * Tujuan: Pusat Komando Enterprise Teqara - Visualisasi data real-time 100% Bahasa Indonesia.
 * Peran: Agregator statistik dari 13 pilar manajemen operasional.
 */
class BerandaUtama extends Component
{
    /**
     * Mengambil metrik agregat dari seluruh sistem.
     * 
     * @return \Illuminate\View\View
     */
    #[Title('Pusat Komando Enterprise - Teqara Hub')]
    public function render()
    {
        // 1. Pilar Halaman Toko (CMS)
        $statistikToko = [
            'total_konten' => KontenHalaman::count(),
            'total_berita' => Berita::count(),
        ];

        // 2. Pilar Produk & Gadget
        $statistikProduk = [
            'total_unit' => Produk::count(),
            'stok_kritis' => Produk::where('stok', '<', 5)->count(),
            'produk_aktif' => Produk::where('status', 'aktif')->count(),
        ];

        // 3. Pilar Pesanan
        $statistikPesanan = [
            'masuk_hari_ini' => Pesanan::whereDate('dibuat_pada', now())->count(),
            'perlu_proses' => Pesanan::where('status_pesanan', 'menunggu')->count(),
        ];

        // 4. Pilar Transaksi & Keuangan
        $statistikKeuangan = [
            'omzet_hari_ini' => Pesanan::whereDate('dibuat_pada', now())->where('status_pembayaran', 'lunas')->sum('total_harga'),
            'pembayaran_pending' => TransaksiPembayaran::where('status', 'menunggu')->count(),
            'voucher_berlaku' => Voucher::where('berlaku_sampai', '>=', now())->count(),
        ];

        // 5. Pilar Customer Service
        $statistikLayanan = [
            'tiket_terbuka' => TiketBantuan::where('status', 'terbuka')->count(),
            'ulasan_terbaru' => Ulasan::whereDate('dibuat_pada', '>=', now()->subDays(3))->count(),
        ];

        // 6. Pilar Logistik Pengiriman
        $statistikLogistik = [
            'dalam_pengiriman' => Pesanan::where('status_pesanan', 'dikirim')->count(),
        ];

        // 7. Pilar Manajemen Vendor
        $statistikVendor = [
            'mitra_aktif' => Pemasok::where('status', 'aktif')->count(),
        ];

        // 8. Pilar Pelanggan (CRM)
        $statistikPelanggan = [
            'total_member' => Pengguna::where('peran', 'pelanggan')->count(),
            'member_baru_bulan_ini' => Pengguna::where('peran', 'pelanggan')->whereMonth('dibuat_pada', now()->month)->count(),
        ];

        // 9. Pilar Pegawai & Peran (SDM)
        $statistikSDM = [
            'total_staf' => Karyawan::count(),
            'staf_hadir_hari_ini' => Karyawan::whereHas('absensi', fn($q) => $q->whereDate('tanggal', now()))->count(),
        ];

        // 10. Pilar Laporan & Analitik
        $grafikOmzet = [];
        $labelWaktu = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = now()->subDays($i);
            $grafikOmzet[] = Pesanan::whereDate('dibuat_pada', $tgl->format('Y-m-d'))
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga');
            $labelWaktu[] = $tgl->translatedFormat('d M');
        }

        // 11. Pilar Pengaturan Sistem
        // 12. Pilar Pengaturan Keamanan
        $statistikKeamanan = [
            'log_aktivitas_hari_ini' => LogAktivitas::whereDate('waktu', now())->count(),
            'aksi_sensitif' => LogAktivitas::whereIn('aksi', ['hapus', 'update_sistem', 'akses_ilegal'])->count(),
        ];

        $aktivitasTerbaru = LogAktivitas::with('pengguna')->latest('waktu')->take(10)->get();

        return view('livewire.pengelola.beranda-utama', [
            'toko' => $statistikToko,
            'produk' => $statistikProduk,
            'pesanan' => $statistikPesanan,
            'keuangan' => $statistikKeuangan,
            'layanan' => $statistikLayanan,
            'logistik' => $statistikLogistik,
            'vendor' => $statistikVendor,
            'pelanggan' => $statistikPelanggan,
            'sdm' => $statistikSDM,
            'keamanan' => $statistikKeamanan,
            'grafik' => [
                'data' => $grafikOmzet,
                'label' => $labelWaktu,
            ],
            'aktivitas' => $aktivitasTerbaru,
        ])->layout('components.layouts.admin');
    }
}