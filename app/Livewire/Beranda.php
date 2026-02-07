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

        $produk = Produk::with('varian')->find($produkId);

        if (!$produk || $produk->stok < 1) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Produk tidak tersedia atau stok habis.']);
            return;
        }

        $varianId = null;
        if ($produk->memiliki_varian && $produk->varian->count() > 0) {
            $varianId = $produk->varian->first()->id;
        }

        // Cek Keranjang Existing
        $keranjang = \App\Models\Keranjang::where('pengguna_id', auth()->id())
            ->where('produk_id', $produkId)
            ->where('varian_id', $varianId)
            ->first();

        if ($keranjang) {
            $keranjang->increment('jumlah');
        } else {
            \App\Models\Keranjang::create([
                'pengguna_id' => auth()->id(),
                'produk_id' => $produkId,
                'varian_id' => $varianId,
                'jumlah' => 1
            ]);
        }

        $this->dispatch('keranjang-diperbarui'); 
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Produk berhasil ditambahkan ke keranjang!']);
    }

    public function render()
    {
        // 1. Ambil Konten Hero dari DB (Pengaturan Sistem / Konten Halaman)
        // Fallback data jika belum ada di database
        $hero = (object) [
            'judul_kecil' => 'Enterprise Ready',
            'judul_utama' => 'Solusi Teknologi Terdepan Untuk Bisnis Anda',
            'deskripsi' => 'Dapatkan perangkat keras dan lunak kelas enterprise dengan harga kompetitif dan dukungan purna jual terpercaya.',
            'url_cta' => '/katalog',
            'teks_cta' => 'MULAI BELANJA',
            'gambar' => null // null means use placeholder
        ];

        // Coba ambil real data jika ada module CMS
        try {
            // Hero Section
            $heroDb = \App\Models\KontenHalaman::where('bagian', 'hero_section')->where('aktif', true)->orderBy('urutan')->first();
            if ($heroDb) {
                $hero = (object) [
                    'judul_kecil' => 'Featured Highlight',
                    'judul_utama' => $heroDb->judul,
                    'deskripsi' => $heroDb->deskripsi,
                    'url_cta' => $heroDb->tautan_tujuan ?? '/katalog',
                    'teks_cta' => $heroDb->teks_tombol ?? 'Lihat Detail',
                    'gambar' => $heroDb->gambar
                ];
            }

            // Promo Banners (Multiple)
            $promoBanners = \App\Models\KontenHalaman::where('bagian', 'promo_banner')
                ->where('aktif', true)
                ->orderBy('urutan')
                ->take(3)
                ->get();

            // Fitur Unggulan / USP
            $fiturUnggulan = \App\Models\KontenHalaman::where('bagian', 'fitur_unggulan')
                ->where('aktif', true)
                ->orderBy('urutan')
                ->take(3)
                ->get();

        } catch (\Exception $e) {
            // Fallback to default if table/model issue
            $promoBanners = collect([]);
            $fiturUnggulan = collect([]);
        }

        // 2. Kategori dengan Ikon
        $kategori = \Illuminate\Support\Facades\Cache::remember('beranda_kategori_v2', 60, function () {
            return Kategori::withCount('produk')
                ->orderBy('nama')
                ->take(6)
                ->get();
        });

        // 3. Produk Unggulan (Pilihan Editor / Terbaru)
        $produkUnggulan = Produk::with(['kategori', 'gambar'])
            ->where('status', 'aktif')
            ->latest()
            ->take(8)
            ->get();

        // 4. Flash Sale Aktif
        $penjualanKilat = \Illuminate\Support\Facades\DB::table('penjualan_kilat')
            ->where('aktif', true)
            ->where('waktu_mulai', '<=', now())
            ->where('waktu_selesai', '>=', now())
            ->first();

        // 5. Berita Terbaru
        $beritaTerbaru = \App\Models\Berita::where('status', 'publikasi')
            ->latest('dibuat_pada')
            ->take(3)
            ->get();

        // 6. Payment Methods Active (Real-time from Admin)
        $paymentConfig = \App\Models\PengaturanSistem::whereIn('kunci', [
            'payment_midtrans_mode', 
            'payment_midtrans_id',
            'payment_xendit_secret' // Check if Xendit is "active" by presence of key
        ])->pluck('nilai', 'kunci');

        return view('livewire.beranda', [
            'hero' => $hero,
            'kategori' => $kategori,
            'produkUnggulan' => $produkUnggulan,
            'penjualanKilat' => $penjualanKilat,
            'beritaTerbaru' => $beritaTerbaru,
            'promoBanners' => $promoBanners ?? collect([]),
            'fiturUnggulan' => $fiturUnggulan ?? collect([]),
            'paymentConfig' => $paymentConfig,
        ])->layout('components.layouts.app');
    }
}
