<?php

namespace App\Livewire\Komponen;

use App\Models\Keranjang;
use Livewire\Attributes\On;
use Livewire\Component;

class NavbarKeranjang extends Component
{
    public $jumlahItem = 0;

    public function mount()
    {
        $this->hitungItem();
    }

    #[On('update-keranjang')]
    public function hitungItem()
    {
        if (auth()->check()) {
            $this->jumlahItem = Keranjang::where('pengguna_id', auth()->id())->sum('jumlah');
        } else {
            $this->jumlahItem = 0;
        }
    }

    public function render()
    {
        return view('livewire.komponen.navbar-keranjang');
    }
}
