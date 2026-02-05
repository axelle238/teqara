<?php

namespace App\Livewire\Pesanan;

use Livewire\Component;
use App\Models\Pesanan;
use Livewire\Attributes\Title;

class Riwayat extends Component
{
    public function getPesananProperty()
    {
        return Pesanan::where('pengguna_id', auth()->id())
            ->with(['detailPesanan.produk'])
            ->latest()
            ->get();
    }

    #[Title('Riwayat Pesanan - Teqara')]
    public function render()
    {
        return view('livewire.pesanan.riwayat')
            ->layout('components.layouts.app');
    }
}
