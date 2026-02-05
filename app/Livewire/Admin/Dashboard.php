<?php

namespace App\Livewire\Admin;

use App\Models\Pesanan;
use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Dasbor Admin - Teqara')]
    public function render()
    {
        $totalPendapatan = Pesanan::where('status_pembayaran', 'lunas')->sum('total_harga');
        $pesananBaru = Pesanan::whereIn('status_pesanan', ['menunggu', 'diproses'])->count();
        $stokMenipis = Produk::where('stok', '<', 5)->count();
        $pesananTerbaru = Pesanan::latest()->take(5)->get();

        // Data Tren Penjualan 7 Hari Terakhir
        $trenPenjualan = [];
        $labelHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $total = Pesanan::whereDate('created_at', $tanggal)
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga');

            $trenPenjualan[] = $total;
            $labelHari[] = now()->subDays($i)->translatedFormat('d M');
        }

        return view('livewire.admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'pesananBaru' => $pesananBaru,
            'stokMenipis' => $stokMenipis,
            'pesananTerbaru' => $pesananTerbaru,
            'dataTren' => $trenPenjualan,
            'labelTren' => $labelHari,
        ])->layout('components.layouts.admin');
    }
}
