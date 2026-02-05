<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pesanan;
use App\Models\TransaksiPembayaran;
use App\Services\PaymentGatewayService;
use Livewire\Attributes\Title;

class BayarPesanan extends Component
{
    public Pesanan $pesanan;
    public $metodeTerpilih = null; // bank_transfer, qris
    public $providerTerpilih = null; // bca, mandiri, gopay
    public $transaksiAktif = null;

    public function mount($invoice)
    {
        $this->pesanan = Pesanan::where('nomor_invoice', $invoice)
            ->where('pengguna_id', auth()->id())
            ->firstOrFail();

        if ($this->pesanan->status_pembayaran === 'lunas') {
            return redirect()->to('/pesanan/lacak/' . $this->pesanan->nomor_invoice);
        }

        // Cek jika ada transaksi pending
        $this->transaksiAktif = TransaksiPembayaran::where('pesanan_id', $this->pesanan->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }

    public function pilihMetode($metode, $provider)
    {
        $this->metodeTerpilih = $metode;
        $this->providerTerpilih = $provider;
    }

    public function buatPembayaran(PaymentGatewayService $service)
    {
        if (!$this->metodeTerpilih) return;

        $this->transaksiAktif = $service->buatTransaksi(
            $this->pesanan, 
            $this->metodeTerpilih, 
            $this->providerTerpilih
        );
    }

    public function simulasiBayarSukses(PaymentGatewayService $service)
    {
        if ($this->transaksiAktif) {
            $service->prosesNotifikasi($this->transaksiAktif->id, 'success');
            
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran Berhasil!']);
            return redirect()->to('/pesanan/lacak/' . $this->pesanan->nomor_invoice);
        }
    }

    #[Title('Pembayaran - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.bayar-pesanan')
            ->layout('components.layouts.app');
    }
}
