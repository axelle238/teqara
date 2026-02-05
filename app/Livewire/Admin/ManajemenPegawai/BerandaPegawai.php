<?php

namespace App\Livewire\Admin\ManajemenPegawai;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaPegawai
 * Tujuan: Beranda pilar Manajemen Pegawai & Peran (SDM).
 */
class BerandaPegawai extends Component
{
    #[Title('Manajemen Pegawai & Peran - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-pegawai.beranda-pegawai', [
            'total_admin' => Pengguna::where('peran', 'admin')->count(),
            'total_staff' => Pengguna::where('peran', 'staff')->count(),
            'daftar_admin' => Pengguna::whereIn('peran', ['admin', 'staff'])->latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
