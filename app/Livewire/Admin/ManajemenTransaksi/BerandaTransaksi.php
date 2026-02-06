<?php

namespace App\Livewire\Admin\ManajemenTransaksi;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class BerandaTransaksi
 * Tujuan: Buku Besar (General Ledger) Keuangan Perusahaan.
 */
class BerandaTransaksi extends Component
{
    use WithPagination;

    public $filterWaktu = 'bulan_ini';

    #[Title('Buku Besar Keuangan - Admin Teqara')]
    public function render()
    {
        $query = Pesanan::query()
            ->with(['pengguna'])
            ->where('status_pembayaran', 'lunas')
            ->latest();

        if ($this->filterWaktu === 'bulan_ini') {
            $query->whereMonth('created_at', now()->month);
        } elseif ($this->filterWaktu === 'minggu_ini') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $transaksi = $query->paginate(15);

        // Kalkulasi Ringkasan
        $totalMasuk = Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga');
        $totalPending = Pesanan::where('status_pembayaran', 'menunggu_verifikasi')->sum('total_harga');
        // Asumsi pengeluaran 30% dari omzet untuk simulasi profit bersih di ledger
        $estimasiKeluar = $totalMasuk * 0.3;

        return view('livewire.admin.manajemen-transaksi.beranda-transaksi', [
            'transaksi' => $transaksi,
            'ringkasan' => [
                'masuk' => $totalMasuk,
                'pending' => $totalPending,
                'keluar' => $estimasiKeluar,
                'saldo' => $totalMasuk - $estimasiKeluar,
            ],
        ])->layout('components.layouts.admin');
    }
}
