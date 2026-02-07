<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailPesanan extends Component
{
    public Pesanan $pesanan;

    public function mount($invoice)
    {
        $this->pesanan = Pesanan::where('nomor_faktur', $invoice)
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
            'selesai' => 4,
            'dibatalkan' => 99 // Special case
        ];

        $statusSaatIni = $urutan[$this->pesanan->status_pesanan] ?? 0;
        $target = $urutan[$tahap] ?? 99;
        
        // Handle cancelled order visual logic specifically if needed
        if ($this->pesanan->status_pesanan == 'dibatalkan') return 'dibatalkan';

        if ($statusSaatIni >= $target) {
            return 'aktif';
        }

        return 'nanti';
    }

    #[Title('Lacak Pesanan - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.detail-pesanan')
            ->layout('components.layouts.app');
    }
}