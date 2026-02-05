<?php

namespace App\Livewire\Admin\Pesanan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPesanan extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public $cari = '';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    #[Title('Kelola Pesanan - Admin Teqara')]
    public function render()
    {
        $query = Pesanan::query()->with('pengguna')->latest();

        if ($this->filterStatus) {
            $query->where('status_pesanan', $this->filterStatus);
        }

        if ($this->cari) {
            $query->where('nomor_invoice', 'like', '%'.$this->cari.'%');
        }

        return view('livewire.admin.pesanan.daftar-pesanan', [
            'pesanan' => $query->paginate(10),
        ])->layout('components.layouts.admin', ['title' => 'Kelola Pesanan']);
    }
}
