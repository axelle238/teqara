<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardProduk extends Component
{
    #[Title('Dashboard Produk - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.produk.dashboard-produk', [
            'total_produk' => Produk::count(),
            'stok_menipis' => Produk::where('stok', '<', 10)->count(),
            'total_kategori' => Kategori::count(),
            'total_merek' => Merek::count(),
            'produk_terbaru' => Produk::latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
