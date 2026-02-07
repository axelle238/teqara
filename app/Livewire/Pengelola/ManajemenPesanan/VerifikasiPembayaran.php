<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\TransaksiPembayaran;
use App\Services\LayananGerbangPembayaran;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class VerifikasiPembayaran
 * Tujuan: Workspace khusus untuk auditor keuangan memvalidasi bukti transfer.
 */
class VerifikasiPembayaran extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $filterStatus = 'menunggu';

    #[Url(history: true)]
    public $filterMetode = '';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function verifikasi($id)
    {
        $layanan = new LayananGerbangPembayaran();
        
        try {
            $trx = TransaksiPembayaran::find($id);
            if (!$trx || $trx->status !== 'menunggu') return;

            $layanan->prosesNotifikasi($id, 'sukses');
            
            LogHelper::catat('verifikasi_pembayaran', $trx->kode_pembayaran, "Pembayaran manual sebesar Rp " . number_format($trx->jumlah_bayar) . " telah divalidasi.");
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran Valid. Pesanan diproses ke tahap selanjutnya.']);
        } catch (\Exception $e) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'System Error: ' . $e->getMessage()]);
        }
    }

    public function tolak($id)
    {
        $layanan = new LayananGerbangPembayaran();
        
        try {
            $trx = TransaksiPembayaran::find($id);
            if (!$trx) return;

            $layanan->prosesNotifikasi($id, 'gagal');
            
            LogHelper::catat('tolak_pembayaran', $trx->kode_pembayaran, "Pembayaran ditolak/tidak valid.");
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Pembayaran ditandai Invalid.']);
        } catch (\Exception $e) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'System Error: ' . $e->getMessage()]);
        }
    }

    #[Title('Verifikasi Pembayaran - Teqara Enterprise')]
    public function render()
    {
        $transaksi = TransaksiPembayaran::query()
            ->with(['pesanan.pengguna'])
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterMetode, fn ($q) => $q->where('metode_pembayaran', $this->filterMetode))
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-pesanan.verifikasi-pembayaran', [
            'pembayaran' => $transaksi,
        ])->layout('components.layouts.admin');
    }
}