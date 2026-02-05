<?php

namespace App\Livewire\Produk;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

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
        $this->dispatch('update-title', title: $this->produk->nama.' - Teqara Store');

        return view('livewire.produk.detail-produk')
            ->layout('components.layouts.app', [
                'title' => $this->produk->nama.' | Teqara',
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
        if (! auth()->check()) {
            $this->dispatch('notifikasi', [
                'tipe' => 'info',
                'pesan' => 'Silakan masuk (login) terlebih dahulu untuk mulai belanja.',
            ]);

            return;
        }

        if ($this->produk->stok < 1) {
            $this->dispatch('notifikasi', [
                'tipe' => 'error',
                'pesan' => 'Maaf, stok produk ini sedang habis.',
            ]);

            return;
        }

        // Simpan ke tabel keranjang
        $item = \App\Models\Keranjang::where('pengguna_id', auth()->id())
            ->where('produk_id', $this->produk->id)
            ->first();

        if ($item) {
            $item->update([
                'jumlah' => $item->jumlah + $this->jumlah,
            ]);
        } else {
            \App\Models\Keranjang::create([
                'pengguna_id' => auth()->id(),
                'produk_id' => $this->produk->id,
                'jumlah' => $this->jumlah,
            ]);
        }

        // Beritahu Navbar untuk update counter
        $this->dispatch('update-keranjang');

        $this->dispatch('notifikasi', [
            'tipe' => 'sukses',
            'pesan' => "{$this->produk->nama} berhasil ditambahkan ke keranjang!",
        ]);
    }
}
