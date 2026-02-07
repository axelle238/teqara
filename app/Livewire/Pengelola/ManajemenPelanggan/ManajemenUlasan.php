<?php

namespace App\Livewire\Pengelola\ManajemenPelanggan;

use App\Helpers\LogHelper;
use App\Models\Ulasan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenUlasan
 * Tujuan: Moderasi ulasan dan feedback pelanggan untuk menjaga kualitas informasi.
 */
class ManajemenUlasan extends Component
{
    use WithPagination;

    public function hapus($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $produkNama = $ulasan->produk->nama;

        LogHelper::catat(
            'hapus_ulasan',
            $produkNama,
            "Admin menghapus ulasan dari {$ulasan->pengguna->nama} pada produk {$produkNama} karena melanggar kebijakan konten."
        );

        $ulasan->delete();
        $this->dispatch('notifikasi', ['tipe' => 'peringatan', 'pesan' => 'Ulasan telah dihapus.']);
    }

    #[Title('Ulasan & Feedback - Admin Teqara')]
    public function render()
    {
        $ulasan = Ulasan::with(['pengguna', 'produk'])->latest('dibuat_pada')->paginate(10);

        return view('livewire.pengelola.manajemen-pelanggan.manajemen-ulasan', [
            'ulasan' => $ulasan,
        ])->layout('components.layouts.admin');
    }
}
