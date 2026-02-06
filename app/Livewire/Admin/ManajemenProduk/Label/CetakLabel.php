<?php

namespace App\Livewire\Admin\ManajemenProduk\Label;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class CetakLabel extends Component
{
    public $produkId;
    public $produk;
    public $jumlahCetak = 1;
    public $tipeLabel = 'barcode_1'; // barcode_1, qr_1, price_tag

    public function mount($id)
    {
        $this->produkId = $id;
        $this->produk = Produk::findOrFail($id);
    }

    public function cetak()
    {
        $this->dispatch('print-window');
    }

    #[Title('Cetak Label & Barcode - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.label.cetak-label')
            ->layout('components.layouts.admin');
    }
}
