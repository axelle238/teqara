<?php

namespace App\Livewire\Pelanggan;

use App\Models\RiwayatPoin as ModelRiwayatPoin;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class JejakPoin extends Component
{
    use WithPagination;

    public $filter = 'semua'; // semua, masuk, keluar

    public function setFilter($tipe)
    {
        $this->filter = $tipe;
        $this->resetPage();
    }

    public function getStatistikProperty()
    {
        $userId = auth()->id();
        return [
            'total_diperoleh' => ModelRiwayatPoin::where('pengguna_id', $userId)->where('jumlah', '>', 0)->sum('jumlah'),
            'total_ditukar' => abs(ModelRiwayatPoin::where('pengguna_id', $userId)->where('jumlah', '<', 0)->sum('jumlah')),
            'transaksi_bulan_ini' => ModelRiwayatPoin::where('pengguna_id', $userId)->whereMonth('dibuat_pada', now()->month)->count(),
        ];
    }

    public function getRiwayatProperty()
    {
        $query = ModelRiwayatPoin::where('pengguna_id', auth()->id());

        if ($this->filter === 'masuk') {
            $query->where('jumlah', '>', 0);
        } elseif ($this->filter === 'keluar') {
            $query->where('jumlah', '<', 0);
        }

        return $query->latest()->paginate(10);
    }

    #[Title('Jejak Poin & Loyalitas - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.riwayat-poin')
            ->layout('components.layouts.app');
    }
}
