<?php

namespace App\Livewire\Pengelola\ManajemenTransaksi;

use App\Models\TransaksiPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class BerandaTransaksi
 * Tujuan: Monitoring arus kas masuk (Cash Flow) dari seluruh channel pembayaran.
 */
class BerandaTransaksi extends Component
{
    use WithPagination;

    public $filterMetode = '';
    public $cari = '';

    public function getRingkasanProperty()
    {
        // Hitung total berdasarkan status
        return [
            'total_masuk' => TransaksiPembayaran::where('status', 'sukses')->sum('jumlah_bayar'),
            'transaksi_sukses' => TransaksiPembayaran::where('status', 'sukses')->count(),
            'transaksi_pending' => TransaksiPembayaran::where('status', 'menunggu')->count(),
            'rata_rata' => TransaksiPembayaran::where('status', 'sukses')->avg('jumlah_bayar') ?? 0,
        ];
    }

    public function verifikasiManual($id)
    {
        $trx = TransaksiPembayaran::findOrFail($id);
        if ($trx->status == 'menunggu') {
            $trx->update(['status' => 'sukses']);
            $trx->pesanan->update([
                'status_pembayaran' => 'lunas',
                'status_pesanan' => 'diproses' // Auto process if paid
            ]);
            
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran diverifikasi manual.']);
        }
    }

    #[Title('Manajemen Keuangan - Teqara Admin')]
    public function render()
    {
        $transaksi = TransaksiPembayaran::with(['pesanan.pengguna'])
            ->when($this->filterMetode, fn($q) => $q->where('metode_pembayaran', $this->filterMetode))
            ->when($this->cari, fn($q) => $q->where('kode_pembayaran', 'like', '%'.$this->cari.'%'))
            ->latest('dibuat_pada')
            ->paginate(15);

        return view('livewire.pengelola.manajemen-transaksi.beranda-transaksi', [
            'transaksi' => $transaksi
        ])->layout('components.layouts.admin', ['header' => 'Pusat Keuangan']);
    }
}
