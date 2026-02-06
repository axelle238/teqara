<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class Beranda
 * Tujuan: Halaman depan utama toko pelanggan dengan visual High-Tech dan Colorful.
 */
class Beranda extends Component
{
    public function addToCart($produkId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $produk = Produk::find($produkId);

        if (!$produk || $produk->stok < 1) {
            $this->dispatch('notifikasi', tipe: 'error', pesan: 'Produk tidak tersedia.');
            return;
        }

        // Cek Keranjang Existing
        $keranjang = \App\Models\Keranjang::where('pengguna_id', auth()->id())
            ->where('produk_id', $produkId)
            ->first();

        if ($keranjang) {
            $keranjang->increment('jumlah');
        } else {
            \App\Models\Keranjang::create([
                'pengguna_id' => auth()->id(),
                'produk_id' => $produkId,
                'jumlah' => 1
            ]);
        }

        $this->dispatch('keranjang-diperbarui'); // Update badge navbar
        $this->dispatch('notifikasi', tipe: 'sukses', pesan: 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function render()
    {
        // Ambil Konten Halaman Hero
        $hero = \Illuminate\Support\Facades\Cache::remember('konten_hero', 60, function () {
            return \App\Models\KontenHalaman::where('bagian', 'hero_section')->first();
        });

        // Cache Kategori (60 Menit)
        $kategori = \Illuminate\Support\Facades\Cache::remember('beranda_kategori', 60, function () {
            return Kategori::withCount('produk')->get();
        });

        // Cache Produk Unggulan (15 Menit)
        $produkUnggulan = \Illuminate\Support\Facades\Cache::remember('beranda_produk_unggulan', 15, function () {
            return Produk::with(['kategori', 'gambar'])
                ->where('status', 'aktif')
                ->orderBy('rating_rata_rata', 'desc')
                ->latest()
                ->take(8)
                ->get();
        });

        // Penjualan Kilat Aktif
        $penjualanKilat = \Illuminate\Support\Facades\Cache::remember('penjualan_kilat_aktif', 60, function () {
            return DB::table('penjualan_kilat')
                ->where('aktif', true)
                ->where('waktu_mulai', '<=', now())
                ->where('waktu_selesai', '>=', now())
                ->first();
        });

        // Statistik Beranda
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

        return view('livewire\Beranda', [
            'hero' => $hero,
            'kategori' => $kategori,
            'produkUnggulan' => $produkUnggulan,
            'penjualanKilat' => $penjualanKilat,
            'statistik' => $statistik,
            'beritaTerbaru' => $beritaTerbaru,
        ])->layout('components.layouts.app');
    }
}
