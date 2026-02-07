<?php

namespace App\Livewire\Pesanan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Riwayat extends Component
{
    use WithPagination;

    #[Url(as: 'status')]
    public $filterStatus = 'semua';

    #[Url(as: 'cari')]
    public $cariInvoice = '';

    #[Url]
    public $tanggalMulai;

    #[Url]
    public $tanggalAkhir;

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function resetFilter()
    {
        $this->reset(['filterStatus', 'cariInvoice', 'tanggalMulai', 'tanggalAkhir']);
        $this->resetPage();
    }

    public function getPesananProperty()
    {
        $query = Pesanan::where('pengguna_id', auth()->id())
            ->with(['detailPesanan.produk']);

        if ($this->filterStatus !== 'semua') {
            $query->where('status_pesanan', $this->filterStatus);
        }

        if ($this->cariInvoice) {
            $query->where('nomor_faktur', 'like', '%' . $this->cariInvoice . '%');
        }

        if ($this->tanggalMulai) {
            $query->whereDate('dibuat_pada', '>=', $this->tanggalMulai);
        }

        if ($this->tanggalAkhir) {
            $query->whereDate('dibuat_pada', '<=', $this->tanggalAkhir);
        }

        return $query->latest()->paginate(10);
    }

    #[Title('Riwayat Pesanan - Teqara')]
    public function render()
    {
        return view('livewire.pesanan.riwayat')
            ->layout('components.layouts.app');
    }
}
