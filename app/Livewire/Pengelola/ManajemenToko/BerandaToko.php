<?php

namespace App\Livewire\Pengelola\ManajemenToko;

use App\Models\Berita;
use App\Models\KontenHalaman;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaToko
 * Tujuan: Pusat Komando Visual & Konten Digital Enterprise.
 * Menampilkan metrik performa konten, status publikasi, dan akses cepat manajemen layout.
 */
class BerandaToko extends Component
{
    #[Title('Pusat Kendali Visual - Teqara Enterprise')]
    public function render()
    {
        // Statistik Konten Visual
        $statsKonten = [
            'total_hero' => KontenHalaman::where('bagian', 'hero_section')->count(),
            'hero_aktif' => KontenHalaman::where('bagian', 'hero_section')->where('aktif', 1)->count(),
            'total_promo' => KontenHalaman::where('bagian', 'promo_banner')->count(),
            'fitur_unggulan' => KontenHalaman::where('bagian', 'fitur_unggulan')->count(),
        ];

        // Statistik Berita/Artikel
        $statsBerita = [
            'total' => Berita::count(),
            'terbit' => Berita::where('status', 'terbit')->count(),
            'draft' => Berita::where('status', 'draft')->count(),
            'total_baca' => Berita::sum('jumlah_baca'),
        ];

        // Feed Aktivitas Konten Terakhir
        $aktivitasKonten = KontenHalaman::latest('diperbarui_pada')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'tipe' => 'Visual',
                    'judul' => $item->judul ?: 'Elemen Tanpa Judul',
                    'bagian' => $this->formatBagian($item->bagian),
                    'waktu' => $item->diperbarui_pada,
                    'status' => $item->aktif ? 'Aktif' : 'Nonaktif',
                    'gambar' => $item->gambar,
                ];
            });

        return view('livewire.pengelola.manajemen-toko.beranda-toko', [
            'konten' => $statsKonten,
            'berita' => $statsBerita,
            'feed' => $aktivitasKonten,
        ])->layout('components.layouts.admin');
    }

    /**
     * Memformat nama bagian sistem menjadi label yang mudah dibaca.
     */
    private function formatBagian($key)
    {
        return match($key) {
            'hero_section' => 'Spanduk Utama',
            'promo_banner' => 'Banner Promo',
            'fitur_unggulan' => 'Fitur Unggulan',
            default => 'Komponen Umum',
        };
    }
}