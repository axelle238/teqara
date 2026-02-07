<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class PusatUnduhan extends Component
{
    public function getDaftarUnduhanProperty()
    {
        // Simulasi: Mengambil produk digital atau dokumen terkait pesanan
        return Pesanan::where('pengguna_id', auth()->id())
            ->where('status_pesanan', 'selesai')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($pesanan) {
                return [
                    'id' => $pesanan->id,
                    'judul' => 'Invoice Pembelian #' . $pesanan->nomor_faktur,
                    'tipe' => 'PDF',
                    'ukuran' => '1.2 MB',
                    'tanggal' => $pesanan->dibuat_pada,
                    'url' => route('pesanan.faktur', $pesanan->nomor_faktur)
                ];
            });
    }

    #[Title('Pusat Unduhan Digital - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.pusat-unduhan')
            ->layout('components.layouts.app');
    }
}
