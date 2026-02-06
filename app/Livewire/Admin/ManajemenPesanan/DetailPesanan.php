<?php

namespace App\Livewire\Admin\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class DetailPesanan
 * Tujuan: Pusat kontrol pemenuhan pesanan individual (Order Fulfillment Center).
 */
class DetailPesanan extends Component
{
    public Pesanan $pesanan;

    // Form State
    public $resiInput = '';
    public $alasanTolak = '';

    public function mount(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan->load(['detailPesanan.produk', 'detailPesanan.varian', 'pengguna', 'transaksiPembayaran']);
        $this->resiInput = $pesanan->resi_pengiriman;
    }

    public function verifikasiPembayaran()
    {
        if ($this->pesanan->status_pembayaran !== 'menunggu_verifikasi') {
            return;
        }

        $this->pesanan->update([
            'status_pembayaran' => 'lunas',
            'status_pesanan' => 'diproses' // Masuk antrian packing
        ]);

        LogHelper::catat('verifikasi_pembayaran', $this->pesanan->nomor_faktur, 'Admin memverifikasi pembayaran manual.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran diverifikasi. Pesanan masuk antrian pengemasan.']);
    }

    public function tolakPembayaran()
    {
        $this->pesanan->update([
            'status_pembayaran' => 'gagal',
            'status_pesanan' => 'batal'
        ]);

        // Opsional: Restore stok di sini jika bisnis mengharuskan restock saat batal
        // (new \App\Services\LayananStok)->kembalikanStok($this->pesanan);

        LogHelper::catat('tolak_pembayaran', $this->pesanan->nomor_faktur, 'Admin menolak bukti pembayaran.');
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Pembayaran ditolak & pesanan dibatalkan.']);
    }

    public function updateResi()
    {
        $this->validate(['resiInput' => 'required|string|min:5']);

        $statusBaru = 'dikirim';
        
        $this->pesanan->update([
            'resi_pengiriman' => $this->resiInput,
            'status_pesanan' => $statusBaru
        ]);

        LogHelper::catat('input_resi', $this->pesanan->nomor_faktur, "Resi pengiriman diupdate: {$this->resiInput}");
        
        $this->dispatch('close-panel-resi'); // Close slide-over if used
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Resi disimpan. Status berubah menjadi DIKIRIM.']);
    }

    public function selesaikanPesanan()
    {
        if ($this->pesanan->status_pesanan !== 'dikirim') return;

        $this->pesanan->update(['status_pesanan' => 'selesai']);
        
        LogHelper::catat('selesai_pesanan', $this->pesanan->nomor_faktur, 'Admin menandai pesanan selesai manual.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesanan ditandai SELESAI.']);
    }

    #[Title('Pusat Kontrol Pesanan - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-pesanan.detail-pesanan')
            ->layout('components.layouts.admin');
    }
}