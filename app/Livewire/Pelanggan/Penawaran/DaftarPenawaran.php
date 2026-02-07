<?php

namespace App\Livewire\Pelanggan\Penawaran;

use App\Models\PenawaranHarga;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPenawaran extends Component
{
    use WithPagination;

    public function getDaftarPenawaranProperty()
    {
        return PenawaranHarga::where('pengguna_id', auth()->id())
            ->latest()
            ->paginate(10);
    }

    #[Title('Daftar Penawaran Harga - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.penawaran.daftar-penawaran')
            ->layout('components.layouts.app');
    }
}
