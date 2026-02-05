<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;

class BandingkanProduk extends Component
{
    public $produkBandings = [];

    public function mount()
    {
        $ids = Session::get('bandingkan_produk', []);
        if (!empty($ids)) {
            $this->produkBandings = Produk::with(['spesifikasi', 'kategori', 'merek'])->whereIn('id', $ids)->get();
        }
    }

    public function hapus($id)
    {
        $ids = Session::get('bandingkan_produk', []);
        $ids = array_diff($ids, [$id]);
        Session::put('bandingkan_produk', $ids);
        
        $this->produkBandings = Produk::with(['spesifikasi', 'kategori', 'merek'])->whereIn('id', $ids)->get();
    }

    #[Title('Bandingkan Produk - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.bandingkan-produk')
            ->layout('components.layouts.app');
    }
}
