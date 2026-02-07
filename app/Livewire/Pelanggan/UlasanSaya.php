<?php

namespace App\Livewire\Pelanggan;

use App\Models\Ulasan;
use Livewire\Attributes\Title;
use Livewire\Component;

class UlasanSaya extends Component
{
    public function getUlasanProperty()
    {
        return Ulasan::where('pengguna_id', auth()->id())
            ->with('produk') // Asumsi ada relasi ke produk
            ->latest()
            ->get();
    }

    #[Title('Ulasan & Penilaian - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.ulasan-saya')
            ->layout('components.layouts.app');
    }
}
