<?php

namespace App\Livewire\Pengelola\ManajemenPelanggan;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;

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
        
        // 2. Top Spenders (Pelanggan Sultan)
        $topSpenders = Pengguna::where('peran', 'pelanggan')
            ->withSum(['pesanan' => function ($q) {
                $q->where('status_pembayaran', 'lunas');
            }], 'total_harga')
            ->orderByDesc('pesanan_sum_total_harga')
            ->take(5)
            ->get();

        // 3. Demografi (Contoh sederhana: Active vs Inactive based on orders)
        $activeUsers = Pengguna::where('peran', 'pelanggan')
            ->whereHas('pesanan', fn($q) => $q->where('dibuat_pada', '>=', now()->subDays(30)))
            ->count();

        return view('livewire.pengelola.manajemen-pelanggan.beranda-pelanggan', [
            'stats' => [
                'total' => $totalPelanggan,
                'baru' => $pelangganBaru,
                'aktif' => $activeUsers,
                'retention_rate' => $totalPelanggan > 0 ? ($activeUsers / $totalPelanggan) * 100 : 0
            ],
            'topSpenders' => $topSpenders
        ])->layout('components.layouts.admin');
    }
}
