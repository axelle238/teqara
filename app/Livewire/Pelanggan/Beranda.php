<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;

class Beranda extends Component
{
    public function getStatsProperty()
    {
        $pengguna = auth()->user();
        return [
            'poin' => $pengguna->poin_loyalitas ?? 0,
            'level' => $pengguna->level_member ?? 'Classic',
            'pesanan_aktif' => Pesanan::where('pengguna_id', $pengguna->id)
                ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dikirim'])
                ->count(),
            'tiket_terbuka' => TiketBantuan::where('pengguna_id', $pengguna->id)
                ->where('status', 'terbuka')
                ->count(),
        ];
    }

    public function getPesananTerakhirProperty()
    {
        return Pesanan::where('pengguna_id', auth()->id())
            ->latest()
            ->take(3)
            ->get();
    }

    public function getRekomendasiProperty()
    {
        return Produk::where('status', 'aktif')
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    #[Title('Dashboard Pelanggan - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.beranda')
            ->layout('components.layouts.app');
    }
}
