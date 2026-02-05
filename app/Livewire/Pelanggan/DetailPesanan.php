<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pesanan;
use Livewire\Attributes\Title;

class DetailPesanan extends Component
{
    public Pesanan $pesanan;

    public function mount($invoice)
    {
        $this->pesanan = Pesanan::where('nomor_invoice', $invoice)
            ->where('pengguna_id', auth()->id())
            ->with(['detailPesanan.produk', 'pengguna'])
            ->firstOrFail();
    }

    // Helper untuk menentukan status timeline aktif
    public function cekStatus($tahap)
    {
        $urutan = [
            'menunggu' => 1,
            'diproses' => 2,
            'dikirim' => 3,
            'selesai' => 4
        ];

        $statusSaatIni = $urutan[$this->pesanan->status_pesanan] ?? 0;
        $target = $urutan[$tahap] ?? 99;

        if ($statusSaatIni >= $target) return 'aktif';
        return 'nanti';
    }

    #[Title('Lacak Pesanan - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.detail-pesanan')
            ->layout('components.layouts.app');
    }
}
