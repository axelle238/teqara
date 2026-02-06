<?php

namespace App\Livewire\Pengelola\LayananPelanggan;

use App\Models\TiketBantuan;
use App\Models\Ulasan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaLayanan
 * Tujuan: Beranda pilar Manajemen Customer Service (Layanan Pelanggan).
 */
class BerandaLayanan extends Component
{
    #[Title('Beranda Layanan Pelanggan - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.layanan-pelanggan.beranda-layanan', [
            'total_tiket' => TiketBantuan::count(),
            'tiket_terbuka' => TiketBantuan::where('status', 'terbuka')->count(),
            'total_ulasan' => Ulasan::count(),
            'ulasan_terbaru' => Ulasan::with(['pengguna', 'produk'])->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
