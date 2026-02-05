<?php

namespace App\Livewire\Admin\ManajemenPelanggan;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaPelanggan
 * Tujuan: Beranda pilar Manajemen Pelanggan (CRM).
 */
class BerandaPelanggan extends Component
{
    #[Title('Beranda Pelanggan - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-pelanggan.beranda-pelanggan', [
            'total_pelanggan' => Pengguna::where('peran', 'pelanggan')->count(),
            'pelanggan_baru_bulan_ini' => Pengguna::where('peran', 'pelanggan')->whereMonth('created_at', now()->month)->count(),
            'pelanggan_terbaru' => Pengguna::where('peran', 'pelanggan')->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
