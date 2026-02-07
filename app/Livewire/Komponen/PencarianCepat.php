<?php

namespace App\Livewire\Komponen;

use App\Models\Produk;
use Livewire\Component;

class PencarianCepat extends Component
{
    public $query = '';
    public $hasil = [];

    public function updatedQuery()
    {
        if (strlen($this->query) < 3) {
            $this->hasil = [];
            return;
        }

        $this->hasil = Produk::where('nama', 'like', '%' . $this->query . '%')
            ->orWhere('deskripsi_singkat', 'like', '%' . $this->query . '%')
            ->where('status', 'aktif')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.komponen.pencarian-cepat');
    }
}
