<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
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

    #[Title('Otoritas Pembayaran - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.bayar-pesanan')
            ->layout('components.layouts.app');
    }
}
