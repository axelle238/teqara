<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarProduk
 * Tujuan: Menampilkan list produk dengan fitur pencarian dan penghapusan.
 */
class DaftarProduk extends Component
{
    use WithPagination;

    public $cari = '';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function hapusProduk($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            $nama = $produk->nama;
            $produk->delete();
            $this->dispatch('notifikasi', [
                'tipe' => 'sukses',
                'pesan' => "Produk $nama berhasil dihapus.",
            ]);
        }
    }

    #[Title('Kelola Produk - Admin Teqara')]
    public function render()
    {
        $produk = Produk::query()
            ->with(['kategori', 'merek'])
            ->when($this->cari, function ($q) {
                $q->where('nama', 'like', '%'.$this->cari.'%')
                    ->orWhere('kode_unit', 'like', '%'.$this->cari.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.daftar-produk', [
            'produk' => $produk,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Produk']);
    }
}
