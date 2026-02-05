<?php

namespace App\Livewire\Admin;

use App\Models\DetailPesanan;
use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaUtama
 * Tujuan: Beranda pusat komando sistem dengan statistik agregat 11 pilar.
 */
class BerandaUtama extends Component
{
    #[Title('Pusat Komando Enterprise - Admin Teqara')]
    public function render()
    {
        // 1. Metrik Utama (Kartu Atas)
        $totalPendapatan = Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga');
        $totalPesanan = Pesanan::count();
        $totalProduk = Produk::count();
        $totalPelanggan = \App\Models\Pengguna::where('peran', 'pelanggan')->count();

        // 2. Statistik Departemen (Hulu ke Hilir)
        $statsManajemen = [
            'stok_menipis' => Produk::where('stok', '<', 10)->count(),
            'menunggu_bayar' => Pesanan::where('status_pembayaran', 'belum_dibayar')->count(),
            'perlu_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'total_karyawan' => \App\Models\Karyawan::count(),
            'insiden_keamanan' => 0,
        ];

        // 3. Analisis Pertumbuhan
        $pendapatanBulanIni = Pesanan::where('status_pembayaran', 'lunas')
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');

        $pendapatanBulanLalu = Pesanan::where('status_pembayaran', 'lunas')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_harga');

        $pertumbuhan = $pendapatanBulanLalu > 0
            ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100
            : 100;

        // 4. Tren Penjualan Harian
        $trenPenjualan = [];
        $labelHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $total = Pesanan::whereDate('created_at', $tanggal->format('Y-m-d'))
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga');

            $trenPenjualan[] = $total;
            $labelHari[] = $tanggal->translatedFormat('d M');
        }

        // 5. Kategori Terlaris
        $kategoriTerlaris = DetailPesanan::select('kategori.nama', DB::raw('SUM(detail_pesanan.subtotal) as total_pendapatan'))
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.status_pembayaran', 'lunas')
            ->groupBy('kategori.id', 'kategori.nama')
            ->orderByDesc('total_pendapatan')
            ->take(5)
            ->get();

        // 6. Aktivitas & Pesanan Terbaru
        $pesananTerbaru = Pesanan::with('pengguna')->latest()->take(5)->get();
        $logTerbaru = LogAktivitas::with('pengguna')->latest('waktu')->take(5)->get();

        return view('livewire.admin.beranda-utama', [
            'metrik' => [
                'pendapatan' => $totalPendapatan,
                'pesanan' => $totalPesanan,
                'produk' => $totalProduk,
                'pelanggan' => $totalPelanggan,
                'pertumbuhan' => $pertumbuhan,
            ],
            'statsManajemen' => $statsManajemen,
            'grafik' => [
                'tren_data' => $trenPenjualan,
                'tren_label' => $labelHari,
                'kategori_label' => $kategoriTerlaris->pluck('nama'),
                'kategori_data' => $kategoriTerlaris->pluck('total_pendapatan'),
            ],
            'pesananTerbaru' => $pesananTerbaru,
            'logTerbaru' => $logTerbaru,
        ])->layout('components.layouts.admin');
    }
}
