<?php

namespace App\Livewire\Admin\ManajemenPesanan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class DetailPesanan
 * Tujuan: Monitoring detail transaksi dan pengelolaan status operasional.
 */
class DetailPesanan extends Component
{
    public Pesanan $pesanan;

    public $statusPesanan;

    public $statusPembayaran;

    public $resiPengiriman;

    public function mount(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan->load(['detailPesanan.produk', 'pengguna']);
        $this->statusPesanan = $pesanan->status_pesanan;
        $this->statusPembayaran = $pesanan->status_pembayaran;
        $this->resiPengiriman = $pesanan->resi_pengiriman;
    }

    public function simpanPerubahan()
    {
        $this->validate([
            'statusPesanan' => 'required',
            'statusPembayaran' => 'required',
            'resiPengiriman' => 'nullable|string|max:100',
        ]);

        $pesananLama = $this->pesanan->replicate();

        $this->pesanan->update([
            'status_pesanan' => $this->statusPesanan,
            'status_pembayaran' => $this->statusPembayaran,
            'resi_pengiriman' => $this->resiPengiriman,
        ]);

        if ($pesananLama->status_pesanan !== $this->statusPesanan) {
            \App\Helpers\LogHelper::catat(
                'update_status_pesanan',
                $this->pesanan->nomor_faktur,
                "Admin memperbarui status pesanan #{$this->pesanan->nomor_faktur} dari ".strtoupper($pesananLama->status_pesanan).' menjadi '.strtoupper($this->statusPesanan)
            );
        }

        if ($pesananLama->status_pembayaran !== $this->statusPembayaran) {
            \App\Helpers\LogHelper::catat(
                'update_status_pembayaran',
                $this->pesanan->nomor_faktur,
                "Admin memperbarui status pembayaran #{$this->pesanan->nomor_faktur} menjadi ".strtoupper(str_replace('_', ' ', $this->statusPembayaran))
            );
        }

        $this->dispatch('notifikasi', [
            'tipe' => 'sukses',
            'pesan' => "Data pesanan #{$this->pesanan->nomor_faktur} berhasil diperbarui.",
        ]);
    }

    #[Title('Detail Transaksi - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-pesanan.detail-pesanan')
            ->layout('components.layouts.admin');
    }
}
