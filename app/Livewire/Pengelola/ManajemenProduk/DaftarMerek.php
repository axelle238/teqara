<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Merek;
use Livewire\Attributes\Title;
use Livewire\Component;

class DaftarMerek extends Component
{
    /**
     * Menghapus merek produk.
     */
    public function hapus($id)
    {
        $m = Merek::withCount('produk')->findOrFail($id);
        
        if ($m->produk_count > 0) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: Merek masih memiliki produk aktif.']);
            return;
        }
        
        $nama = $m->nama;
        $m->delete();
        
        LogHelper::catat('hapus_merek', $nama, "Merek {$nama} dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Merek berhasil dihapus.']);
    }

    #[Title('Master Merek - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.merek.daftar-merek', [
            'merek' => Merek::withCount('produk')->latest()->get()
        ])->layout('components.layouts.admin');
    }
}
