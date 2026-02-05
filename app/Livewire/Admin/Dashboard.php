<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pesanan;
use App\Models\Produk;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    #[Title('Dasbor Admin - Teqara')]
    public function render()
    {
        $totalPendapatan = Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga');
        $pesananBaru = Pesanan::whereIn('status_pesanan', ['menunggu', 'diproses'])->count();
        $stokMenipis = Produk::where('stok', '<', 5)->count();
        $pesananTerbaru = Pesanan::latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'pesananBaru' => $pesananBaru,
            'stokMenipis' => $stokMenipis,
            'pesananTerbaru' => $pesananTerbaru,
        ])->layout('components.layouts.admin');
    }
}
