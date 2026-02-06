<?php

namespace App\Observers;

use App\Models\Produk;
use App\Services\LayananDokumentasi;
use Illuminate\Support\Str;

/**
 * Class ProdukObserver
 * Tujuan: Mengamati siklus hidup model Produk untuk sinkronisasi metadata.
 * Peran: Otomasi slug Bahasa Indonesia, SEO, dan Dokumentasi Hidup.
 */
class ProdukObserver
{
    /**
     * @param LayananDokumentasi $layanan
     */
    public function __construct(protected LayananDokumentasi $layanan) {}

    /**
     * Kejadian sebelum produk disimpan (buat/ubah).
     */
    public function saving(Produk $produk): void
    {
        // 1. Otomasi Slug Bahasa Indonesia
        if (empty($produk->slug) || $produk->isDirty('nama')) {
            $produk->slug = Str::slug($produk->nama);
        }

        // 2. Pembersihan kode unit (SKU)
        if ($produk->isDirty('kode_unit')) {
            $produk->kode_unit = strtoupper($produk->kode_unit);
        }
    }

    /**
     * Kejadian setelah produk berhasil disimpan.
     */
    public function saved(Produk $produk): void
    {
        // Update dokumentasi sistem otomatis
        $this->layanan->perbaruiDokumentasi();
    }

    /**
     * Kejadian setelah produk dihapus.
     */
    public function deleted(Produk $produk): void
    {
        $this->layanan->perbaruiDokumentasi();
    }
}