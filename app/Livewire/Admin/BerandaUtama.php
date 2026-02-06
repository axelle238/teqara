<?php

namespace App\Livewire\Admin;

use App\Models\Berita;
use App\Models\DetailPesanan;
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
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaUtama
 * Tujuan: Pusat Komando Enterprise untuk monitoring seluruh ekosistem Teqara secara real-time.
 */
class BerandaUtama extends Component
{
    #[Title('Pusat Komando Enterprise - Teqara')]
    public function render()
    {
        // 1. Pilar Halaman Toko
        $statsToko = [
            'total_konten' => KontenHalaman::count(),
            'total_berita' => Berita::count(),
        ];

        // 2. Pilar Produk & Gadget
        $statsProduk = [
            'total_unit' => Produk::count(),
            'stok_kritis' => Produk::where('stok', '<', 5)->count(),
            'produk_aktif' => Produk::where('status', 'aktif')->count(),
        ];

        // 3. Pilar Pesanan
        $statsPesanan = [
            'hari_ini' => Pesanan::whereDate('created_at', now())->count(),
            'perlu_diproses' => Pesanan::where('status_pesanan', 'menunggu')->count(),
        ];

        // 4. Pilar Transaksi & Keuangan
        $statsKeuangan = [
            'pendapatan_hari_ini' => Pesanan::whereDate('created_at', now())->where('status_pembayaran', 'lunas')->sum('total_harga'),
            'verifikasi_tertunda' => Pesanan::where('status_pembayaran', 'menunggu_verifikasi')->count(),
            'voucher_aktif' => Voucher::where('berlaku_mulai', '<=', now())
                ->where('berlaku_sampai', '>=', now())
                ->where('kuota', '>', 0)
                ->count(),
        ];

        // 5. Pilar Customer Service
        $statsCS = [
            'tiket_terbuka' => TiketBantuan::where('status', 'terbuka')->count(),
            'ulasan_baru' => Ulasan::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];

        // 6. Pilar Logistik & Pengiriman
        $statsLogistik = [
            'pengiriman_aktif' => Pesanan::where('status_pesanan', 'dikirim')->count(),
        ];

        // 7. Pilar Manajemen Vendor (NEW)
        $statsVendor = [
            'total_vendor' => Pemasok::count(),
            'vendor_aktif' => Pemasok::where('status', 'aktif')->count(),
        ];

        // 8. Pilar Pelanggan (CRM)
        $statsPelanggan = [
            'total_member' => Pengguna::where('peran', 'pelanggan')->count(),
            'member_baru' => Pengguna::where('peran', 'pelanggan')->whereMonth('created_at', now()->month)->count(),
        ];

        // 9. Pilar Pegawai (HRD)
        $statsHRD = [
            'total_staf' => Karyawan::count(),
            'staf_aktif' => Karyawan::where('status', 'aktif')->count(),
        ];

        // 10. Grafik Tren Pendapatan (7 Hari Terakhir)
        $grafikTren = [];
        $labelHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $total = Pesanan::whereDate('created_at', $tanggal->format('Y-m-d'))
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga');

            $grafikTren[] = $total;
            $labelHari[] = $tanggal->translatedFormat('d M');
        }

        // 11. Aktivitas Terbaru (Narasi Manusiawi)
        $aktivitasTerbaru = LogAktivitas::with('pengguna')->latest('waktu')->take(10)->get();
        
        // 12. Keamanan
        $statsKeamanan = [
            'log_hari_ini' => LogAktivitas::whereDate('waktu', now())->count(),
            'aksi_kritis' => LogAktivitas::whereIn('aksi', ['delete', 'update_keamanan'])->count(),
        ];

        return view('livewire.admin.beranda-utama', [
            'toko' => $statsToko,
            'produk' => $statsProduk,
            'pesanan' => $statsPesanan,
            'keuangan' => $statsKeuangan,
            'cs' => $statsCS,
            'logistik' => $statsLogistik,
            'vendor' => $statsVendor,
            'pelanggan' => $statsPelanggan,
            'hrd' => $statsHRD,
            'keamanan' => $statsKeamanan,
            'grafik' => [
                'data' => $grafikTren,
                'label' => $labelHari,
            ],
            'aktivitas' => $aktivitasTerbaru,
        ])->layout('components.layouts.admin');
    }
}
