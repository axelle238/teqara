<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaProduk
 * Tujuan: Beranda pilar Manajemen Produk & Gadget.
 */
class BerandaProduk extends Component
{
    #[Title('Manajemen Produk & Gadget - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.beranda-produk', [
            'total_produk' => Produk::count(),
            'stok_menipis' => Produk::where('stok', '<', 10)->count(),
            'total_kategori' => Kategori::count(),
            'total_merek' => Merek::count(),
            'produk_terbaru' => Produk::latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
