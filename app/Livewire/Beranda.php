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
        // 1. Audit Trail: Catat Kunjungan Pelanggan secara Naratif
        if (auth()->check()) {
            \App\Helpers\LogHelper::catat(
                'Kunjungan Beranda',
                'Frontend',
                "Pelanggan '" . auth()->user()->nama . "' sedang menjelajahi halaman beranda toko."
            );
        }

        // 2. Ambil Konten Hero (Dinamis dari CMS)
        $hero = (object) [
            'judul_kecil' => 'Enterprise Ready',
            'judul_utama' => 'Solusi Teknologi Terdepan Untuk Bisnis Anda',
            'deskripsi' => 'Dapatkan perangkat keras dan lunak kelas enterprise dengan harga kompetitif.',
            'url_cta' => '/katalog',
            'teks_cta' => 'MULAI BELANJA',
            'gambar' => null
        ];

        try {
            $heroDb = \App\Models\KontenHalaman::where('bagian', 'hero_section')->where('aktif', true)->orderBy('urutan')->first();
            if ($heroDb) {
                $hero = (object) [
                    'judul_kecil' => 'Top Highlight',
                    'judul_utama' => $heroDb->judul,
                    'deskripsi' => $heroDb->deskripsi,
                    'url_cta' => $heroDb->tautan_tujuan ?? '/katalog',
                    'teks_cta' => $heroDb->teks_tombol ?? 'Lihat Detail',
                    'gambar' => $heroDb->gambar
                ];
            }
            $promoBanners = \App\Models\KontenHalaman::where('bagian', 'promo_banner')->where('aktif', true)->orderBy('urutan')->get();
            $fiturUnggulan = \App\Models\KontenHalaman::where('bagian', 'fitur_unggulan')->where('aktif', true)->orderBy('urutan')->get();
            $faqData = \App\Models\KontenHalaman::where('bagian', 'faq_section')->where('aktif', true)->orderBy('urutan')->get();
            $ctaFooter = \App\Models\KontenHalaman::where('bagian', 'cta_footer')->where('aktif', true)->orderBy('urutan')->first();
        } catch (\Exception $e) {
            $promoBanners = collect([]); 
            $fiturUnggulan = collect([]);
            $faqData = collect([]);
            $ctaFooter = null;
        }

        // 3. Produk & Kategori (Cached for Performance)
        $kategori = \Illuminate\Support\Facades\Cache::remember('beranda_kategori_v4', 3600, function () {
            return Kategori::withCount('produk')->orderByDesc('produk_count')->take(6)->get();
        });

        $produkUnggulan = Produk::with(['kategori', 'gambar', 'ulasan'])
            ->withCount('ulasan')
            ->where('status', 'aktif')
            ->latest()
            ->take(8)
            ->get();

        // 4. Flash Sale (Real-time Enterprise)
        $penjualanKilat = \App\Models\PenjualanKilat::with(['produkPenjualanKilat.produk'])
            ->where('aktif', true)
            ->where('waktu_mulai', '<=', now())
            ->where('waktu_selesai', '>=', now())
            ->first();

        // 5. Berita & Insights
        $beritaTerbaru = \App\Models\Berita::where('status', 'publikasi')->latest('dibuat_pada')->take(3)->get();

        return view('livewire.beranda', [
            'hero' => $hero,
            'kategori' => $kategori,
            'produkUnggulan' => $produkUnggulan,
            'penjualanKilat' => $penjualanKilat,
            'beritaTerbaru' => $beritaTerbaru,
            'promoBanners' => $promoBanners,
            'fiturUnggulan' => $fiturUnggulan,
            'faqData' => $faqData,
            'ctaFooter' => $ctaFooter,
        ])->layout('components.layouts.app');
    }
}
