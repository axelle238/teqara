<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Beranda extends Component
{
    public function render()
    {
        // Ambil Konten CMS Hero
        $hero = \Illuminate\Support\Facades\Cache::remember('cms_hero', 60, function () {
            return DB::table('cms_konten')->where('bagian', 'hero_section')->first();
        });

        // Cache Kategori (60 Menit)
        $kategori = \Illuminate\Support\Facades\Cache::remember('beranda_kategori', 60, function () {
            return Kategori::withCount('produk')->get();
        });

        // Cache Produk Unggulan (15 Menit) - Agar stok update relatif cepat
        $produkUnggulan = \Illuminate\Support\Facades\Cache::remember('beranda_produk_unggulan', 15, function () {
            return Produk::with(['kategori', 'gambar'])
                ->where('status', 'aktif')
                ->orderBy('rating_rata_rata', 'desc')
                ->latest()
                ->take(8)
                ->get();
        });

        // Flash Sale Aktif
        $flashSale = \Illuminate\Support\Facades\Cache::remember('flash_sale_aktif', 60, function () {
            return DB::table('flash_sale')
                ->where('aktif', true)
                ->where('waktu_mulai', '<=', now())
                ->where('waktu_selesai', '>=', now())
                ->first();
        });

        // Statistik Beranda (Real-time atau Short Cache 5 menit)
        $statistik = \Illuminate\Support\Facades\Cache::remember('beranda_statistik', 5, function () {
            return [
                'transaksi_sukses' => Pesanan::where('status_pembayaran', 'lunas')->count() + 1250,
                'produk_aktif' => Produk::where('status', 'aktif')->count(),
                'pelanggan_puas' => 850,
            ];
        });

        // Berita & Informasi Terbaru
        $beritaTerbaru = \Illuminate\Support\Facades\Cache::remember('beranda_berita', 30, function () {
            return \App\Models\Berita::with('penulis')
                ->where('status', 'publikasi')
                ->latest()
                ->take(3)
                ->get();
        });

        return view('livewire.beranda', [
            'hero' => $hero,
            'kategori' => $kategori,
            'produkUnggulan' => $produkUnggulan,
            'flashSale' => $flashSale,
            'statistik' => $statistik,
            'beritaTerbaru' => $beritaTerbaru,
        ])->layout('components.layouts.app');
    }
}
