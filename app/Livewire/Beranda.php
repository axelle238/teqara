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
        // Ambil Semua Blok Konten CMS (Hero, Promo, Fitur)
        $semuaKonten = \Illuminate\Support\Facades\Cache::remember('konten_halaman_all', 60, function () {
            return \App\Models\KontenHalaman::orderBy('urutan')->get()->groupBy('bagian');
        });

        // Ekstrak Hero secara eksplisit untuk view
        $hero = isset($semuaKonten['hero_section']) ? $semuaKonten['hero_section']->first() : null;

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

        // Penjualan Kilat Aktif
        $penjualanKilat = \Illuminate\Support\Facades\Cache::remember('penjualan_kilat_aktif', 60, function () {
            return \Illuminate\Support\Facades\DB::table('penjualan_kilat')
                ->where('aktif', true)
                ->where('waktu_mulai', '<=', now())
                ->where('waktu_selesai', '>=', now())
                ->first();
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
            'konten' => $semuaKonten,
            'hero' => $hero,
            'kategori' => $kategori,
            'produkUnggulan' => $produkUnggulan,
            'produkTerlaris' => $produkTerlaris,
            'penjualanKilat' => $penjualanKilat,
            'beritaTerbaru' => $beritaTerbaru,
        ])->layout('components.layouts.app');
    }
}
