<?php

namespace App\Livewire\Admin\Pesanan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardPesanan extends Component
{
    #[Title('Dashboard Pesanan - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.pesanan.dashboard-pesanan', [
            'total_pesanan' => Pesanan::count(),
            'menunggu_bayar' => Pesanan::where('status_pembayaran', 'belum_dibayar')->count(),
            'perlu_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'selesai_bulan_ini' => Pesanan::where('status_pesanan', 'selesai')->whereMonth('created_at', now()->month)->count(),
            'pesanan_terbaru' => Pesanan::with('pengguna')->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
