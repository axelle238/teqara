<?php

namespace App\Livewire;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\LogAktivitas;
use Livewire\Attributes\Title;
use Livewire\Component;

class KeranjangBelanja extends Component
{
    public function getItemsProperty()
    {
        return Keranjang::where('pengguna_id', auth()->id())
            ->with(['produk.kategori', 'produk.gambar'])
            ->get();
    }

    public function tambahJumlah($id)
    {
        $item = Keranjang::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->first();

        if ($item && $item->jumlah < $item->produk->stok) {
            $item->increment('jumlah');
            $this->dispatch('update-keranjang');
        } else {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Batas stok tercapai.']);
        }
    }

    public function kurangJumlah($id)
    {
        $item = Keranjang::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->first();

        if ($item && $item->jumlah > 1) {
            $item->decrement('jumlah');
            $this->dispatch('update-keranjang');
        }
    }

    public function hapusItem($id)
    {
        Keranjang::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->delete();

        $this->dispatch('update-keranjang');
        $this->dispatch('notifikasi', [
            'tipe' => 'info',
            'pesan' => 'Unit dihapus dari antrian belanja.',
        ]);
    }

    public function bersihkanKeranjang()
    {
        Keranjang::where('pengguna_id', auth()->id())->delete();
        $this->dispatch('update-keranjang');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Seluruh antrian belanja telah dibersihkan.']);
    }

    public function getTotalHargaProperty()
    {
        return $this->items->sum(function ($item) {
            return $item->produk->harga_jual * $item->jumlah;
        });
    }

    public function getRekomendasiProperty()
    {
        return Produk::where('status', 'aktif')
            ->orderByDesc('rating_rata_rata')
            ->take(4)
            ->get();
    }

    #[Title('Sistem Manajemen Keranjang - Teqara')]
    public function render()
    {
        return view('livewire.keranjang-belanja')
            ->layout('components.layouts.app');
    }
}
