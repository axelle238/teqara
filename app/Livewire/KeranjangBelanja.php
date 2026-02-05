<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Keranjang;
use Livewire\Attributes\Title;

class KeranjangBelanja extends Component
{
    public function getItemsProperty()
    {
        return Keranjang::where('pengguna_id', auth()->id())
            ->with('produk')
            ->get();
    }
    
    // ... method lainnya tetap sama ...

    public function tambahJumlah($id)
    {
        $item = Keranjang::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->first();

        if ($item && $item->jumlah < $item->produk->stok) {
            $item->increment('jumlah');
            $this->dispatch('update-keranjang');
        }
    }

    public function kurangJumlah($id)
    {
        $item = Keranjang::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->first();

        if ($item && $item->jumlah > 1) {
            $item->decrement('jumlah');
            $this->dispatch('update-keranjang');
        }
    }

    public function hapusItem($id)
    {
        Keranjang::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->delete();

        $this->dispatch('update-keranjang');
        $this->dispatch('notifikasi', [
            'tipe' => 'info',
            'pesan' => 'Produk berhasil dihapus dari keranjang.'
        ]);
    }

    public function getTotalHargaProperty()
    {
        return $this->items->sum(function ($item) {
            return $item->produk->harga_jual * $item->jumlah;
        });
    }

    #[Title('Keranjang Belanja - Teqara')]
    public function render()
    {
        return view('livewire.keranjang-belanja')
            ->layout('components.layouts.app');
    }
}
