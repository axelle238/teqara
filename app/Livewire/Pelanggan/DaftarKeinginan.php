<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;

class DaftarKeinginan extends Component
{
    public function hapus($produkId)
    {
        auth()->user()->wishlist()->detach($produkId);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Produk dihapus dari keinginan.']);
    }

    #[Title('Daftar Keinginan Saya - Teqara')]
    public function render()
    {
        $wishlist = auth()->user()->wishlist()->with(['kategori', 'gambar'])->get();

        return view('livewire.pelanggan.daftar-keinginan', [
            'wishlist' => $wishlist,
        ])->layout('components.layouts.app');
    }
}
