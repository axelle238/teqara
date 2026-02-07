<?php

namespace App\Livewire\Pengelola;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Pengguna;
use App\Models\TransaksiPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;

class BerandaUtama extends Component
{
    public function getStatsProperty()
    {
        return [
            'pendapatan_bulan_ini' => TransaksiPembayaran::whereMonth('dibuat_pada', now()->month)
                ->where('status', 'sukses')
                ->sum('jumlah_bayar'),
            'pesanan_baru' => Pesanan::where('status_pesanan', 'menunggu')->count(),
            'produk_aktif' => Produk::where('status', 'aktif')->count(),
            'pelanggan_baru' => Pengguna::whereMonth('dibuat_pada', now()->month)
                ->where('peran', 'pelanggan')
                ->count(),
        ];
    }

    public function getPesananTerbaruProperty()
    {
        return Pesanan::with('pengguna')
            ->latest('dibuat_pada')
            ->take(5)
            ->get();
    }

    #[Title('Dashboard Eksekutif - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.beranda-utama')
            ->layout('components.layouts.admin', ['header' => 'Dashboard Eksekutif']);
    }
}
