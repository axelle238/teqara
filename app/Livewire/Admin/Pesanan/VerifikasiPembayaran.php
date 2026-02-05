<?php

namespace App\Livewire\Admin\Pesanan;

use App\Helpers\LogHelper;
use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class VerifikasiPembayaran
 * Tujuan: Memvalidasi arus kas masuk dari berbagai gateway/transfer manual.
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
            $pesanan->nomor_invoice,
            "Admin memvalidasi pembayaran untuk invoice #{$pesanan->nomor_invoice}. Transaksi kini berstatus LUNAS."
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

        return view('livewire.admin.pesanan.verifikasi-pembayaran', [
            'pembayaran' => $pembayaran,
        ])->layout('components.layouts.admin');
    }
}
