<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use App\Models\PengaturanSistem;
use App\Models\TransaksiPembayaran;
use App\Services\LayananGerbangPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BayarPesanan
 * Tujuan: Proses penyelesaian pembayaran pesanan pelanggan via gerbang digital.
 */
class BayarPesanan extends Component
{
    public Pesanan $pesanan;

    public $metodeTerpilih = null;

    public $providerTerpilih = null;

    public $transaksiAktif = null;
    public $clientKey = '';
    public $snapUrl = '';

    public function mount($invoice)
    {
        $this->pesanan = Pesanan::where('nomor_faktur', $invoice)
            ->where('pengguna_id', auth()->id())
            ->firstOrFail();

        if ($this->pesanan->status_pembayaran === 'lunas') {
            return redirect()->to('/pesanan/lacak/'.$this->pesanan->nomor_faktur);
        }

        $this->transaksiAktif = TransaksiPembayaran::where('pesanan_id', $this->pesanan->id)
            ->where('status', 'menunggu')
            ->latest()
            ->first();

        // Load Midtrans Client Key & Snap URL
        $settings = PengaturanSistem::pluck('nilai', 'kunci');
        $this->clientKey = $settings['payment_midtrans_client'] ?? config('services.midtrans.client_key');
        
        $mode = $settings['payment_midtrans_mode'] ?? 'sandbox';
        $this->snapUrl = $mode === 'production' 
            ? 'https://app.midtrans.com/snap/snap.js' 
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    public function getAvailableMethodsProperty()
    {
        $settings = PengaturanSistem::pluck('nilai', 'kunci');
        $methods = [];

        // Midtrans
        if (!empty($settings['payment_midtrans_server'])) {
            $methods['midtrans'] = [
                'name' => 'Midtrans Payment',
                'channels' => ['bca', 'mandiri', 'bni', 'gopay'], // Simplified for UI
                'mode' => $settings['payment_midtrans_mode'] ?? 'sandbox'
            ];
        }

        // Xendit
        if (!empty($settings['payment_xendit_secret'])) {
            $methods['xendit'] = [
                'name' => 'Xendit Payment',
                'channels' => ['bca', 'bri', 'dana', 'ovo'],
                'mode' => 'production' // Assume prod if key exists
            ];
        }

        // Default Manual Transfer if no gateway configured
        if (empty($methods)) {
            $methods['manual'] = [
                'name' => 'Transfer Bank Manual',
                'channels' => ['bca_manual', 'mandiri_manual'],
                'mode' => 'manual'
            ];
        }

        return $methods;
    }

    public function pilihMetode($metode, $provider)
    {
        $this->metodeTerpilih = $metode;
        $this->providerTerpilih = $provider;
    }

    public function buatPembayaran(LayananGerbangPembayaran $layanan)
    {
        if (! $this->metodeTerpilih) {
            return;
        }

        $this->transaksiAktif = $layanan->buatTransaksi(
            $this->pesanan,
            $this->metodeTerpilih,
            $this->providerTerpilih
        );
    }

    public function simulasiBayarSukses(LayananGerbangPembayaran $layanan)
    {
        if ($this->transaksiAktif) {
            $layanan->prosesNotifikasi($this->transaksiAktif->id, 'sukses');

            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran Berhasil Diverifikasi!']);

            return redirect()->to('/pesanan/lacak/'.$this->pesanan->nomor_faktur);
        }
    }

    public function batalTransaksi()
    {
        if ($this->transaksiAktif) {
            $this->transaksiAktif->update(['status' => 'dibatalkan']);
        }
        
        $this->transaksiAktif = null;
        $this->metodeTerpilih = null;
        $this->providerTerpilih = null;
        
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Silakan pilih metode pembayaran baru.']);
    }

    #[Title('Otoritas Pembayaran - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.bayar-pesanan', [
            'availableMethods' => $this->availableMethods
        ])->layout('components.layouts.app');
    }
}
