<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaProduk
 * Tujuan: Beranda pilar Manajemen Produk & Gadget (Executive Dashboard).
 */
class BerandaProduk extends Component
{
    #[Title('Manajemen Produk & Gadget - Admin Teqara')]
    public function render()
    {
        // Analitik Stok per Kategori
        $stokPerKategori = Produk::select('kategori.nama', DB::raw('SUM(produk.stok) as total_stok'))
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->groupBy('kategori.nama')
            ->get();

        // Data Chart (Placeholder untuk demo visual)
        $chartData = [
            'labels' => $stokPerKategori->pluck('nama')->toArray(),
            'series' => $stokPerKategori->pluck('total_stok')->toArray(),
        ];

        return view('livewire.pengelola.manajemen-produk.beranda-produk', [
            'total_produk' => Produk::count(),
            'stok_menipis' => Produk::where('stok', '<', 10)->count(),
            'total_kategori' => Kategori::count(),
            'total_merek' => Merek::count(),
            'produk_terbaru' => Produk::latest()->take(5)->get(),
            'chart_data' => $chartData,
        ])->layout('components.layouts.admin');
    }
}
