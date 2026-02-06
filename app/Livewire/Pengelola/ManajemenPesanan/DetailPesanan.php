<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class DetailPesanan
 * Tujuan: Pusat kontrol pemenuhan pesanan individual (Order Fulfillment Center).
 * Arsitektur: 100% Full Page & Inline SPA (Tanpa Slide Over/Modal).
 */
class DetailPesanan extends Component
{
    public Pesanan $pesanan;

    // State Antarmuka
    public $modeInputResi = false;

    // Form State
    public $resiInput = '';
    public $alasanTolak = '';

    public function mount(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan->load(['detailPesanan.produk', 'detailPesanan.varian', 'pengguna', 'transaksiPembayaran']);
        $this->resiInput = $pesanan->resi_pengiriman;
    }

    /**
     * Beralih ke mode input resi (Full Section).
     */
    public function aktifkanModeResi()
    {
        $this->modeInputResi = true;
    }

    /**
     * Membatalkan mode input resi.
     */
    public function batalResi()
    {
        $this->modeInputResi = false;
        $this->resiInput = $this->pesanan->resi_pengiriman;
    }

    /**
     * Verifikasi pembayaran masuk.
     */
    public function verifikasiPembayaran()
    {
        if ($this->pesanan->status_pembayaran !== 'menunggu_verifikasi') {
            return;
        }

        $this->pesanan->update([
            'status_pembayaran' => 'lunas',
            'status_pesanan' => 'diproses'
        ]);

        LogHelper::catat('verifikasi_pembayaran', $this->pesanan->nomor_faktur, 'Admin memverifikasi bukti pembayaran sebagai valid.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran lunas. Pesanan siap dikemas.']);
    }

    /**
     * Menolak pembayaran.
     */
    public function tolakPembayaran()
    {
        $this->pesanan->update([
            'status_pembayaran' => 'gagal',
            'status_pesanan' => 'batal'
        ]);

        LogHelper::catat('tolak_pembayaran', $this->pesanan->nomor_faktur, 'Admin menolak bukti pembayaran pelanggan.');
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Pembayaran ditolak. Pesanan otomatis dibatalkan.']);
    }

    /**
     * Memperbarui nomor resi logistik.
     */
    public function updateResi()
    {
        $this->validate([
            'resiInput' => 'required|string|min:5'
        ], [
            'resiInput.required' => 'Nomor resi wajib diisi.',
            'resiInput.min' => 'Nomor resi minimal 5 karakter.',
        ]);

        $this->pesanan->update([
            'resi_pengiriman' => $this->resiInput,
            'status_pesanan' => 'dikirim'
        ]);

        LogHelper::catat('input_resi', $this->pesanan->nomor_faktur, "Nomor resi logistik diupdate: {$this->resiInput}");
        
        $this->modeInputResi = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Resi berhasil disimpan. Status menjadi DIKIRIM.']);
    }

    /**
     * Menandai pesanan selesai.
     */
    public function selesaikanPesanan()
    {
        if ($this->pesanan->status_pesanan !== 'dikirim') return;

        $this->pesanan->update(['status_pesanan' => 'selesai']);
        
        LogHelper::catat('selesai_pesanan', $this->pesanan->nomor_faktur, 'Admin menutup transaksi secara manual.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Transaksi diselesaikan. Terima kasih.']);
    }

    #[Title('Kontrol Transaksi - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-pesanan.detail-pesanan')
            ->layout('components.layouts.admin');
    }
}
