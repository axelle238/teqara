<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Component;

class Beranda extends Component
{
    public function render()
    {
        // Ambil kategori untuk ditampilkan di menu
        $kategori = Kategori::all();

        // Ambil 4 produk terbaru
        $produkTerbaru = \App\Models\Produk::with(['kategori', 'merek'])
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.beranda', [
            'kategori' => $kategori,
            'produkTerbaru' => $produkTerbaru,
        ])->layout('components.layouts.app');
    }
}
