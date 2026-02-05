<?php

namespace App\Livewire\Komponen;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Merek;

class SpotlightSearch extends Component
{
    public $query = '';
    public $hasilProduk = [];
    public $hasilKategori = [];
    public $hasilMerek = [];

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->reset(['hasilProduk', 'hasilKategori', 'hasilMerek']);
            return;
        }

        $this->hasilProduk = Produk::where('nama', 'like', '%' . $this->query . '%')
            ->where('status', 'aktif')
            ->take(5)
            ->get();

        $this->hasilKategori = Kategori::where('nama', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get();

        $this->hasilMerek = Merek::where('nama', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.komponen.spotlight-search');
    }
}
