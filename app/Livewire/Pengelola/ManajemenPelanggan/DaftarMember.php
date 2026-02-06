<?php

namespace App\Livewire\Pengelola\ManajemenPelanggan;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarMember extends Component
{
    use WithPagination;

    public $cari = '';

    #[Title('Direktori Pelanggan - Teqara Admin')]
    public function render()
    {
        $query = Pengguna::where('peran', 'pelanggan')
            ->withCount('pesanan')
            ->withSum(['pesanan' => function ($q) {
                $q->where('status_pembayaran', 'lunas');
            }], 'total_harga')
            ->latest();

        if ($this->cari) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%'.$this->cari.'%')
                  ->orWhere('email', 'like', '%'.$this->cari.'%')
                  ->orWhere('telepon', 'like', '%'.$this->cari.'%');
            });
        }

        return view('livewire.pengelola.manajemen-pelanggan.daftar-member', [
            'member' => $query->paginate(10)
        ])->layout('components.layouts.admin');
    }
}
