<?php

namespace App\Livewire\Pelanggan\Langganan;

use App\Models\Langganan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarLangganan extends Component
{
    use WithPagination;

    public function getLanggananProperty()
    {
        return Langganan::where('pengguna_id', auth()->id())
            ->with('produk')
            ->latest()
            ->paginate(10);
    }

    #[Title('Langganan Saya - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.langganan.daftar-langganan')
            ->layout('components.layouts.app');
    }
}
