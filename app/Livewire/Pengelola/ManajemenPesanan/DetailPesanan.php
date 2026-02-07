<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\TransaksiPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailPesanan extends Component
{
    public Pesanan $pesanan;
    public $resiPengiriman;

    public function mount($pesanan)
    {
        $this->pesanan = Pesanan::with(['pengguna', 'detailPesanan.produk', 'detailPesanan.varian'])
            ->findOrFail($pesanan);
        $this->resiPengiriman = $this->pesanan->resi_pengiriman;
    }

    public function updateResi()
    {
        $this->validate(['resiPengiriman' => 'required|min:5']);
        
        $this->pesanan->update([
            'resi_pengiriman' => $this->resiPengiriman,
            'status_pesanan' => 'dikirim'
        ]);

        LogHelper::catat('update_resi', "Order #{$this->pesanan->nomor_faktur}", "Resi diupdate: {$this->resiPengiriman}");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Nomor resi berhasil diperbarui.']);
    }

    public function verifikasiPembayaran()
    {
        $this->pesanan->update(['status_pembayaran' => 'lunas']);
        
        // Update transaksi terkait jika ada
        TransaksiPembayaran::where('pesanan_id', $this->pesanan->id)
            ->where('status', 'menunggu')
            ->update(['status' => 'sukses']);

        // Jika stok belum dipotong (misal sistem hold), pastikan stok aman di sini (opsional tergantung flow)
        if ($this->pesanan->status_pesanan == 'menunggu') {
            $this->pesanan->update(['status_pesanan' => 'diproses']);
        }

        LogHelper::catat('verifikasi_bayar', "Order #{$this->pesanan->nomor_faktur}", 'Pembayaran diverifikasi manual oleh admin.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran diverifikasi lunas.']);
    }

    public function batalkanPesanan()
    {
        $this->pesanan->update(['status_pesanan' => 'batal']);
        (new \App\Services\LayananStok)->kembalikanStok($this->pesanan);
        
        LogHelper::catat('batal_pesanan', "Order #{$this->pesanan->nomor_faktur}", 'Admin membatalkan pesanan secara manual.');
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Pesanan dibatalkan. Stok dikembalikan.']);
    }

    public function tandaiSelesai()
    {
        $this->pesanan->update(['status_pesanan' => 'selesai']);
        // Trigger point reward logic here if needed
        LogHelper::catat('selesaikan_pesanan', "Order #{$this->pesanan->nomor_faktur}", 'Pesanan ditandai selesai oleh admin.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesanan ditandai selesai.']);
    }

    public function getLogAktivitasProperty()
    {
        return LogAktivitas::where('target', $this->pesanan->nomor_faktur)
            ->latest('waktu')
            ->get();
    }

    #[Title('Detail Pesanan - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-pesanan.detail-pesanan')
            ->layout('components.layouts.admin', ['header' => 'Rincian Transaksi']);
    }
}
