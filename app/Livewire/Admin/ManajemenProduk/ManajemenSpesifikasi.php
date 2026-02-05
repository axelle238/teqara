<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Models\Produk;
use App\Models\SpesifikasiProduk;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class ManajemenSpesifikasi
 * Tujuan: Mengelola parameter teknis produk secara mendalam (No Modal).
 */
class ManajemenSpesifikasi extends Component
{
    public Produk $produk;

    public $spesifikasi = [];

    public $inputJudul;

    public $inputNilai;

    public function mount(Produk $produk)
    {
        $this->produk = $produk;
        $this->muatSpesifikasi();
    }

    public function muatSpesifikasi()
    {
        $this->spesifikasi = SpesifikasiProduk::where('produk_id', $this->produk->id)->get();
    }

    public function tambah()
    {
        $this->validate([
            'inputJudul' => 'required',
            'inputNilai' => 'required',
        ]);

        SpesifikasiProduk::create([
            'produk_id' => $this->produk->id,
            'judul' => $this->inputJudul,
            'nilai' => $this->inputNilai,
        ]);

        $this->reset(['inputJudul', 'inputNilai']);
        $this->muatSpesifikasi();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Spesifikasi ditambahkan.']);
    }

    public function hapus($id)
    {
        SpesifikasiProduk::destroy($id);
        $this->muatSpesifikasi();
    }

    #[Title('Atur Spesifikasi - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.manajemen-spesifikasi')
            ->layout('components.layouts.admin');
    }
}
