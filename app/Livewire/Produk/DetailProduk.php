<?php

namespace App\Livewire\Produk;

use Livewire\Component;
use App\Models\Produk;
use Livewire\Attributes\Title;

class DetailProduk extends Component
{
    public $produk;
    public $jumlah = 1;

    public function mount($slug)
    {
        $this->produk = Produk::where('slug', $slug)
            ->with(['kategori', 'merek'])
            ->firstOrFail();
            
        // Validasi stok awal
        if ($this->produk->stok < 1) {
            $this->jumlah = 0;
        }
    }

    #[Title('Detail Produk')]
    public function render()
    {
        // Set Judul Halaman Dinamis untuk SEO
        $this->dispatch('update-title', title: $this->produk->nama . ' - Teqara Store');

        return view('livewire.produk.detail-produk')
            ->layout('components.layouts.app', [
                'title' => $this->produk->nama . ' | Teqara',
            ]);
    }

    public function tambahJumlah()
    {
        if ($this->jumlah < $this->produk->stok) {
            $this->jumlah++;
        }
    }

    public function kurangJumlah()
    {
        if ($this->jumlah > 1) {
            $this->jumlah--;
        }
    }

    public function tambahKeKeranjang()
    {
        // Placeholder: Logika Keranjang akan diimplementasikan di Tahap 3
        // Simulasi notifikasi sukses
        
        if ($this->produk->stok < 1) {
            return;
        }

        // TODO: Simpan ke tabel keranjang
        
        $this->dispatch('notifikasi', [
            'tipe' => 'sukses',
            'pesan' => "{$this->produk->nama} berhasil ditambahkan ke keranjang!"
        ]);
    }
}
