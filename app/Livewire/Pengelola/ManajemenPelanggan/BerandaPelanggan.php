<?php

namespace App\Livewire\Pengelola\ManajemenPelanggan;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaPelanggan
 * Tujuan: Dashboard CRM Enterprise untuk analisis perilaku dan loyalitas pelanggan.
 */
class BerandaPelanggan extends Component
{
    #[Title('CRM Dashboard - Teqara Admin')]
    public function render()
    {
        // 1. Statistik Utama
        $totalPelanggan = Pengguna::where('peran', 'pelanggan')->count();
        $pelangganBaru = Pengguna::where('peran', 'pelanggan')
            ->whereMonth('dibuat_pada', now()->month)
            ->count();
        
        // 2. Top Spenders (Pelanggan Sultan) - 5 Teratas
        $topSpenders = Pengguna::where('peran', 'pelanggan')
            ->withSum(['pesanan' => function ($q) {
                $q->where('status_pembayaran', 'lunas');
            }], 'total_harga')
            ->orderByDesc('pesanan_sum_total_harga')
            ->take(5)
            ->get();

        // 3. Demografi: Active vs Inactive based on orders in last 30 days
        $activeUsers = Pengguna::where('peran', 'pelanggan')
            ->whereHas('pesanan', fn($q) => $q->where('dibuat_pada', '>=', now()->subDays(30)))
            ->count();

        // 4. Lifetime Value Rata-rata
        $totalRevenue = \App\Models\Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga');
        $avgLTV = $totalPelanggan > 0 ? $totalRevenue / $totalPelanggan : 0;

        return view('livewire.pengelola.manajemen-pelanggan.beranda-pelanggan', [
            'stats' => [
                'total' => $totalPelanggan,
                'baru' => $pelangganBaru,
                'aktif' => $activeUsers,
                'avg_ltv' => $avgLTV
            ],
            'topSpenders' => $topSpenders
        ])->layout('components.layouts.admin');
    }
}