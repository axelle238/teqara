<?php

namespace App\Livewire\Admin\Transaksi;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardTransaksi extends Component
{
    #[Title('Dashboard Transaksi - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.transaksi.dashboard-transaksi', [
            'total_omzet' => Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga'),
            'pending_verifikasi' => Pesanan::where('status_pembayaran', 'menunggu_verifikasi')->count(),
            'gagal_bayar' => Pesanan::where('status_pembayaran', 'gagal')->count(),
            'transaksi_terbaru' => Pesanan::with('pengguna')->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
