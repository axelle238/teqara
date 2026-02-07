<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use Livewire\Attributes\Title;
use Livewire\Component;

class DaftarKategori extends Component
{
    /**
     * Menghapus kategori produk.
     */
    public function hapus($id)
    {
        $k = Kategori::withCount('produk')->findOrFail($id);
        
        if ($k->produk_count > 0) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: Kategori masih memiliki produk aktif.']);
            return;
        }
        
        $nama = $k->nama;
        $k->delete();
        
        LogHelper::catat('hapus_kategori', $nama, "Kategori {$nama} dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kategori berhasil dihapus.']);
    }

    #[Title('Master Kategori - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.kategori.daftar-kategori', [
            'kategori' => Kategori::withCount('produk')->latest('dibuat_pada')->get()
        ])->layout('components.layouts.admin');
    }
}
