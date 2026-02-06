<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaPesanan
 * Tujuan: Beranda pilar Manajemen Pesanan.
 */
class BerandaPesanan extends Component
{
    #[Title('Manajemen Pesanan - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-pesanan.beranda-pesanan', [
            'total_pesanan' => Pesanan::count(),
            'menunggu_bayar' => Pesanan::where('status_pembayaran', 'belum_dibayar')->count(),
            'perlu_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'selesai_bulan_ini' => Pesanan::where('status_pesanan', 'selesai')->whereMonth('dibuat_pada', now()->month)->count(),
            'pesanan_terbaru' => Pesanan::with('pengguna')->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
