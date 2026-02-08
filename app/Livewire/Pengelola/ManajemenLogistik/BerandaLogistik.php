<?php

namespace App\Livewire\Pengelola\ManajemenLogistik;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaLogistik
 * Tujuan: Beranda pilar Manajemen Logistik & Pengiriman.
 */
class BerandaLogistik extends Component
{
    #[Title('Beranda Logistik - Admin Teqara')]
    public function render()
    {
        $pengirimanTerkini = Pesanan::with(['pengguna', 'detailPesanan'])
            ->whereIn('status_pesanan', ['diproses', 'dikirim', 'selesai'])
            ->latest('diperbarui_pada')
            ->take(5)
            ->get();

        return view('livewire.pengelola.manajemen-logistik.beranda-logistik', [
            'siap_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'sedang_dikirim' => Pesanan::where('status_pesanan', 'dikirim')->count(),
            'sampai_tujuan' => Pesanan::where('status_pesanan', 'selesai')->count(),
            'pengiriman_terkini' => $pengirimanTerkini
        ])->layout('components.layouts.admin');
    }
}
