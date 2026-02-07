<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class BeliLagi extends Component
{
    public function getRiwayatProdukProperty()
    {
        // Get products from completed orders, grouped by product_id to show unique items
        // In a real high-traffic app, this should be an optimized query or a dedicated table 'frequently_bought'
        
        $userId = auth()->id();

        // Subquery approach or simpler collection grouping for MVP
        $items = DetailPesanan::whereHas('pesanan', function($q) use ($userId) {
                $q->where('pengguna_id', $userId)
                  ->where('status_pesanan', 'selesai');
            })
            ->with('produk')
            ->latest()
            ->get()
            ->unique('produk_id')
            ->take(20);

        return $items;
    }

    public function tambahKeKeranjang($produkId)
    {
        // Emit event to global cart component
        $this->dispatch('tambah-keranjang', produkId: $produkId, jumlah: 1);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Produk ditambahkan ke keranjang.']);
    }

    #[Title('Beli Lagi - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.beli-lagi')
            ->layout('components.layouts.app');
    }
}
