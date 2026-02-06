<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Produk;
use Livewire\Component;

/**
 * Class Beranda
 * Tujuan: Halaman depan utama toko pelanggan dengan visual High-Tech dan Colorful.
 */
class Beranda extends Component
{
    public function render()
    {
        // Ambil Semua Blok Konten CMS (Hero, Promo, Fitur)
        $semuaKonten = \Illuminate\Support\Facades\Cache::remember('konten_halaman_all', 60, function () {
            return \App\Models\KontenHalaman::orderBy('urutan')->get()->groupBy('bagian');
        });

        // Cache Kategori (60 Menit)
        $kategori = \Illuminate\Support\Facades\Cache::remember('beranda_kategori', 60, function () {
            return Kategori::withCount('produk')->get();
        });

        // Cache Produk Unggulan (15 Menit)
        $produkUnggulan = \Illuminate\Support\Facades\Cache::remember('beranda_produk_unggulan', 15, function () {
            return Produk::with(['kategori', 'gambar'])
                ->where('status', 'aktif')
                ->latest() // Menampilkan produk terbaru sebagai unggulan default
                ->take(12)
                ->get();
        });

        // Cache Produk Terlaris (Berdasarkan rating/best seller)
        $produkTerlaris = \Illuminate\Support\Facades\Cache::remember('beranda_produk_terlaris', 60, function () {
            return Produk::with(['kategori', 'gambar'])
                ->where('status', 'aktif')
                ->orderByDesc('rating_rata_rata')
                ->take(8)
                ->get();
        });

        return view('livewire.beranda', [
            'konten' => $semuaKonten,
            'kategori' => $kategori,
            'produkUnggulan' => $produkUnggulan,
            'produkTerlaris' => $produkTerlaris,
        ])->layout('components.layouts.app');
    }
}
