<?php

namespace App\Livewire\Admin;

use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Executive Dashboard - Teqara')]
    public function render()
    {
        // 1. Metrik Utama (Kartu Atas)
        $totalPendapatan = Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga');
        $totalPesanan = Pesanan::count();
        $totalProduk = Produk::count();
        $totalPelanggan = \App\Models\Pengguna::where('peran', 'pelanggan')->count();

        // 2. Analisis Pertumbuhan (Bulan Ini vs Bulan Lalu)
        $pendapatanBulanIni = Pesanan::where('status_pembayaran', 'lunas')
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');

        $pendapatanBulanLalu = Pesanan::where('status_pembayaran', 'lunas')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_harga');

        $pertumbuhan = $pendapatanBulanLalu > 0
            ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100
            : 100;

        // 3. Tren Penjualan Harian (Grafik Area)
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

        // 4. Kategori Terlaris (Grafik Donut)
        $kategoriTerlaris = DetailPesanan::select('kategori.nama', DB::raw('SUM(detail_pesanan.subtotal) as total_pendapatan'))
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.status_pembayaran', 'lunas')
            ->groupBy('kategori.id', 'kategori.nama')
            ->orderByDesc('total_pendapatan')
            ->take(5)
            ->get();

        // 5. Aktivitas & Pesanan Terbaru
        $pesananTerbaru = Pesanan::with('pengguna')->latest()->take(5)->get();
        $logTerbaru = LogAktivitas::with('pengguna')->latest('waktu')->take(5)->get();

        return view('livewire.admin.dashboard', [
            'metrik' => [
                'pendapatan' => $totalPendapatan,
                'pesanan' => $totalPesanan,
                'produk' => $totalProduk,
                'pelanggan' => $totalPelanggan,
                'pertumbuhan' => $pertumbuhan,
            ],
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
