<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaPesanan
 * Tujuan: Pusat Komando Transaksi & Fulfillment.
 * Menyajikan metrik kesehatan penjualan, status pemenuhan, dan tren pendapatan harian.
 */
class BerandaPesanan extends Component
{
    #[Title('Pusat Komando Pesanan - Teqara Enterprise')]
    public function render()
    {
        // 1. Statistik Kunci
        $stats = [
            'total_pesanan' => Pesanan::count(),
            'omzet_total' => Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga'),
            'menunggu_bayar' => Pesanan::where('status_pembayaran', 'belum_dibayar')->count(),
            'perlu_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'selesai_bulan_ini' => Pesanan::where('status_pesanan', 'selesai')
                ->whereMonth('dibuat_pada', now()->month)
                ->count(),
            'rata_rata_order' => Pesanan::where('status_pembayaran', 'lunas')->avg('total_harga') ?? 0,
        ];

        // 2. Grafik Tren Pesanan Harian (7 Hari Terakhir)
        $grafikPesanan = [];
        $grafikOmzet = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            
            $data = Pesanan::whereDate('dibuat_pada', $date)
                ->select(DB::raw('COUNT(*) as total_count'), DB::raw('SUM(CASE WHEN status_pembayaran="lunas" THEN total_harga ELSE 0 END) as total_omzet'))
                ->first();

            $grafikPesanan[] = $data->total_count;
            $grafikOmzet[] = $data->total_omzet;
        }

        $chart = [
            'labels' => $labels,
            'pesanan' => $grafikPesanan,
            'omzet' => $grafikOmzet
        ];

        // 3. Feed Pesanan Masuk Terbaru
        $feedTerbaru = Pesanan::with('pengguna')
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->latest('dibuat_pada')
            ->take(5)
            ->get();

        return view('livewire.pengelola.manajemen-pesanan.beranda-pesanan', [
            'stats' => $stats,
            'chart' => $chart,
            'feed' => $feedTerbaru,
        ])->layout('components.layouts.admin');
    }
}