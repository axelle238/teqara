<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\Pesanan;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarLaporan extends Component
{
    use WithPagination;

    public $tanggalMulai;

    public $tanggalSelesai;

    public $statusFilter = 'lunas';

    public function mount()
    {
        // Default: Laporan bulan ini
        $this->tanggalMulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggalSelesai = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updated()
    {
        $this->resetPage();
    }

    #[Title('Laporan Penjualan - Admin')]
    public function render()
    {
        $query = Pesanan::query()
            ->with(['pengguna', 'detailPesanan'])
            ->whereBetween('created_at', [
                $this->tanggalMulai.' 00:00:00',
                $this->tanggalSelesai.' 23:59:59',
            ]);

        if ($this->statusFilter) {
            $query->where('status_pembayaran', $this->statusFilter);
        }

        $semuaData = $query->get();
        $totalOmzet = $semuaData->sum('total_harga');
        $totalPesanan = $semuaData->count();

        return view('livewire.admin.laporan.daftar-laporan', [
            'pesanan' => $query->latest()->paginate(15),
            'totalOmzet' => $totalOmzet,
            'totalPesanan' => $totalPesanan,
        ])->layout('components.layouts.admin', ['title' => 'Laporan Penjualan']);
    }
}
