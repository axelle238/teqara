<?php

namespace App\Livewire\Komponen;

use App\Models\Keranjang;
use Livewire\Attributes\On;
use Livewire\Component;

class KeranjangPreview extends Component
{
    public $isOpen = false;

    #[On('open-slide-over')]
    public function openPanel($id)
    {
        if ($id === 'keranjang-preview') {
            $this->isOpen = true;
        }
    }

    #[On('update-keranjang')]
    public function refresh() {}

    public function hapusItem($id)
    {
        Keranjang::destroy($id);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Item dihapus.']);
    }

    public function render()
    {
        $items = auth()->check()
            ? Keranjang::with('produk')->where('pengguna_id', auth()->id())->get()
            : collect([]);

        return view('livewire.komponen.keranjang-preview', [
            'items' => $items,
            'total' => $items->sum(fn ($i) => $i->jumlah * $i->produk->harga_jual),
        ]);
    }
}
