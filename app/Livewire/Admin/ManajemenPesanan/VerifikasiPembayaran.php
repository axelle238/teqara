<?php

namespace App\Livewire\Admin\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class VerifikasiPembayaran
 * Tujuan: Memvalidasi arus kas masuk dari berbagai gerbang pembayaran atau transfer manual.
 */
class VerifikasiPembayaran extends Component
{
    use WithPagination;

    public $filterStatus = 'menunggu_verifikasi';

    public function verifikasi($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pembayaran' => 'lunas',
            'status_pesanan' => 'diproses',
        ]);

        LogHelper::catat(
            'verifikasi_bayar',
            $pesanan->nomor_faktur,
            "Admin memvalidasi pembayaran untuk faktur #{$pesanan->nomor_faktur}. Transaksi kini berstatus LUNAS."
        );

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran berhasil diverifikasi.']);
    }

    #[Title('Verifikasi Pembayaran - Admin Teqara')]
    public function render()
    {
        $pembayaran = Pesanan::query()
            ->with(['pengguna'])
            ->whereIn('status_pembayaran', ['menunggu_verifikasi', 'lunas', 'gagal'])
            ->when($this->filterStatus, fn ($q) => $q->where('status_pembayaran', $this->filterStatus))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manajemen-pesanan.verifikasi-pembayaran', [
            'pembayaran' => $pembayaran,
        ])->layout('components.layouts.admin');
    }
}
