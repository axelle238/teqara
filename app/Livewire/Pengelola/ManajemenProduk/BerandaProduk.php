<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaProduk
 * Tujuan: Dashboard Eksekutif untuk Pilar Manajemen Produk & Gadget.
 * Menyajikan analitik inventaris, performa penjualan produk, dan status stok.
 */
class BerandaProduk extends Component
{
    #[Title('Dashboard Inventaris - Teqara Enterprise')]
    public function render()
    {
        // 1. Statistik Utama
        $stats = [
            'total_sku' => Produk::count(),
            'total_stok_fisik' => Produk::sum('stok'),
            'stok_kritis' => Produk::where('stok', '<', 5)->count(),
            'produk_nonaktif' => Produk::where('status', 'nonaktif')->count(),
            'total_kategori' => Kategori::count(),
            'total_merek' => Merek::count(),
        ];

        // 2. Top 5 Produk Terlaris (Berdasarkan jumlah terjual di detail pesanan)
        $produkTerlaris = DetailPesanan::select('produk_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->with('produk')
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // 3. Distribusi Kategori (Untuk Chart)
        $distribusiKategori = Produk::select('kategori.nama', DB::raw('COUNT(produk.id) as jumlah_produk'))
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->groupBy('kategori.nama')
            ->orderByDesc('jumlah_produk')
            ->take(8) // Top 8 kategori
            ->get();

        $chartData = [
            'labels' => $distribusiKategori->pluck('nama')->toArray(),
            'data' => $distribusiKategori->pluck('jumlah_produk')->toArray(),
        ];

        // 4. Feed Stok Menipis Terbaru
        $stokMenipisFeed = Produk::where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        return view('livewire.pengelola.manajemen-produk.beranda-produk', [
            'stats' => $stats,
            'terlaris' => $produkTerlaris,
            'chart' => $chartData,
            'stok_feed' => $stokMenipisFeed,
        ])->layout('components.layouts.admin');
    }
}