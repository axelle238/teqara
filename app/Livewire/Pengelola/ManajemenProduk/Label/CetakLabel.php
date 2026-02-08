<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Label;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class CetakLabel extends Component
{
    public $produkId;
    public $produk;
    public $jumlahCetak = 1;
    public $tipeLabel = 'barcode_1'; // barcode_1, qr_1, price_tag
    public $cariProduk = '';
    public $hasilPencarian = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->pilihProduk($id);
        }
    }

    public function updatedCariProduk($value)
    {
        if (strlen($value) > 2) {
            $this->hasilPencarian = Produk::where('nama', 'like', '%' . $value . '%')
                ->orWhere('kode_unit', 'like', '%' . $value . '%')
                ->take(5)
                ->get();
        } else {
            $this->hasilPencarian = [];
        }
    }

    public function pilihProduk($id)
    {
        $this->produkId = $id;
        $this->produk = Produk::findOrFail($id);
        $this->hasilPencarian = [];
        $this->cariProduk = '';
    }

    public function cetak()
    {
        $this->dispatch('print-window');
    }

    #[Title('Cetak Label & Barcode - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.label.cetak-label')
            ->layout('components.layouts.admin');
    }
}
