<?php

namespace App\Livewire;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PencarianGlobal extends Component
{
    #[Url]
    public $q = '';

    public function getHasilPencarianProperty()
    {
        if (strlen($this->q) < 3) return collect();

        return Produk::where('nama', 'like', '%' . $this->q . '%')
            ->orWhere('deskripsi_singkat', 'like', '%' . $this->q . '%')
            ->orWhereHas('kategori', function ($query) {
                $query->where('nama', 'like', '%' . $this->q . '%');
            })
            ->where('status', 'aktif')
            ->take(20)
            ->get();
    }

    #[Title('Pencarian - Teqara')]
    public function render()
    {
        return view('livewire.pencarian-global')
            ->layout('components.layouts.app');
    }
}