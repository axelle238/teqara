<?php

namespace App\Livewire\Pengelola\ManajemenVendor;

use App\Helpers\LogHelper;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarPemasok
 * Tujuan: Direktori mitra pemasok (vendor) untuk rantai pasok teknologi.
 */
class DaftarPemasok extends Component
{
    use WithPagination;

    public $cari = '';

    public function hapus($id)
    {
        $p = Pemasok::findOrFail($id);
        $nama = $p->nama_perusahaan;
        $p->delete();
        
        LogHelper::catat('hapus_pemasok', $nama, "Data kemitraan vendor '{$nama}' dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Data vendor berhasil dihapus."]);
    }

    #[Title('Direktori Vendor Enterprise - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-vendor.daftar-pemasok', [
            'daftar_pemasok' => Pemasok::where('nama_perusahaan', 'like', '%'.$this->cari.'%')
                ->orWhere('kode_pemasok', 'like', '%'.$this->cari.'%')
                ->latest('dibuat_pada')
                ->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
