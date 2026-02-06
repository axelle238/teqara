<?php

namespace App\Livewire\Admin\ManajemenTransaksi;

use App\Models\TransaksiPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class BerandaTransaksi
 * Tujuan: Pusat kontrol finansial (Financial Control Tower).
 */
class BerandaTransaksi extends Component
{
    use WithPagination;

    public $filterMetode = '';
    public $cari = '';

    #[Title('Manajemen Transaksi Finansial - Admin Teqara')]
    public function render()
    {
        $query = TransaksiPembayaran::query()
            ->with('pesanan.pengguna')
            ->latest();

        if ($this->filterMetode) {
            $query->where('metode_pembayaran', $this->filterMetode);
        }

        if ($this->cari) {
            $query->where('kode_pembayaran', 'like', '%'.$this->cari.'%');
        }

        // Statistik Finansial
        $totalMasuk = TransaksiPembayaran::where('status', 'success')->sum('jumlah_bayar');
        $transaksiSukses = TransaksiPembayaran::where('status', 'success')->count();
        $transaksiPending = TransaksiPembayaran::where('status', 'pending')->count();
        
        // Data Grafik Metode Pembayaran
        $metodeStats = TransaksiPembayaran::selectRaw('provider, count(*) as total')
            ->groupBy('provider')
            ->get();

        return view('livewire.admin.manajemen-transaksi.beranda-transaksi', [
            'transaksi' => $query->paginate(15),
            'stats' => [
                'total_masuk' => $totalMasuk,
                'sukses' => $transaksiSukses,
                'pending' => $transaksiPending,
                'metode' => $metodeStats
            ]
        ])->layout('components.layouts.admin');
    }
}