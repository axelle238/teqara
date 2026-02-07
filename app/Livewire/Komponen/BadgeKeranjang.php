<?php

namespace App\Livewire\Komponen;

use App\Models\Keranjang;
use Livewire\Attributes\On;
use Livewire\Component;

class BadgeKeranjang extends Component
{
    public $jumlahItem = 0;

    public function mount()
    {
        $this->hitungItem();
    }

    #[On('update-keranjang')]
    #[On('keranjang-diperbarui')]
    public function hitungItem()
    {
        if (auth()->check()) {
            $this->jumlahItem = (int) Keranjang::where('pengguna_id', auth()->id())->sum('jumlah');
        } else {
            $this->jumlahItem = 0;
        }
    }

    public function render()
    {
        return view('livewire.komponen.badge-keranjang');
    }
}
