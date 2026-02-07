<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;

class DaftarKeinginan extends Component
{
    public function getWishlistProperty()
    {
        if (!auth()->check()) {
            return collect();
        }
        return auth()->user()->wishlist()->with(['kategori'])->get();
    }

    public function hapus($id)
    {
        auth()->user()->wishlist()->detach($id);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Produk dihapus dari wishlist.']);
    }

    public function tambahKeKeranjang($produkId)
    {
        $this->dispatch('tambah-keranjang', produkId: $produkId, jumlah: 1);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Produk ditambahkan ke keranjang.']);
    }

    #[Title('Wishlist & Favorit - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.daftar-keinginan')
            ->layout('components.layouts.app');
    }
}
