<?php

namespace App\Livewire\Admin\ManajemenPesanan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarPesanan
 * Tujuan: Manajemen list transaksi pesanan pelanggan.
 */
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

    #[Title('Kelola Pesanan Transaksi - Admin Teqara')]
    public function render()
    {
        $query = Pesanan::query()
            ->with(['pengguna', 'detailPesanan'])
            ->latest();

        if ($this->filterStatus) {
            $query->where('status_pesanan', $this->filterStatus);
        }

        if ($this->cari) {
            $query->where(function ($q) {
                $q->where('nomor_faktur', 'like', '%'.$this->cari.'%')
                    ->orWhereHas('pengguna', fn ($p) => $p->where('nama', 'like', '%'.$this->cari.'%'));
            });
        }

        return view('livewire.admin.manajemen-pesanan.daftar-pesanan', [
            'pesanan' => $query->paginate(10),
            'statistik' => [
                'total' => Pesanan::count(),
                'menunggu' => Pesanan::where('status_pesanan', 'menunggu')->count(),
                'proses' => Pesanan::where('status_pesanan', 'diproses')->count(),
                'selesai' => Pesanan::where('status_pesanan', 'selesai')->count(),
            ],
        ])->layout('components.layouts.admin');
    }
}
