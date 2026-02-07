<?php

namespace App\Livewire\Pelanggan;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProdukTerakhirDilihat extends Component
{
    public function getProdukListProperty()
    {
        $ids = session()->get('produk_terakhir_dilihat', []);
        
        if (empty($ids)) {
            return collect();
        }

        // Pertahankan urutan sesi (LIFO)
        return Produk::whereIn('id', $ids)
            ->with(['kategori', 'gambar'])
            ->get()
            ->sortBy(function ($model) use ($ids) {
                return array_search($model->id, $ids);
            });
    }

    #[Title('Jejak Penelusuran - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.produk-terakhir-dilihat')
            ->layout('components.layouts.app');
    }
}
