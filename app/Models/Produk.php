<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Produk
 * Tujuan: Manajemen data unit komputasi, gadget, dan inventaris hulu.
 */
class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $guarded = ['id'];

    protected $casts = [
        'memiliki_varian' => 'boolean',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function merek(): BelongsTo
    {
        return $this->belongsTo(Merek::class, 'merek_id');
    }

    public function varian(): HasMany
    {
        return $this->hasMany(VarianProduk::class, 'produk_id');
    }

    public function gambar(): HasMany
    {
        return $this->hasMany(GambarProduk::class, 'produk_id')->orderBy('urutan');
    }

    public function spesifikasi(): HasMany
    {
        return $this->hasMany(SpesifikasiProduk::class, 'produk_id');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'produk_id');
    }

    public function mutasiStok(): HasMany
    {
        return $this->hasMany(MutasiStok::class, 'produk_id');
    }

    public function stokGudang(): HasMany
    {
        return $this->hasMany(StokGudang::class, 'produk_id');
    }

    public function produkSeri(): HasMany
    {
        return $this->hasMany(ProdukSeri::class, 'produk_id');
    }

    public function produkPenjualanKilat(): HasMany
    {
        return $this->hasMany(ProdukPenjualanKilat::class, 'produk_id');
    }

    public function getGambarUtamaUrlAttribute()
    {
        $gambar = $this->gambar->where('is_utama', true)->first() ?? $this->gambar->first();

        return $gambar ? $gambar->url : 'https://via.placeholder.com/400x400?text=Tanpa+Gambar';
    }

    public function getHargaRupiahAttribute()
    {
        if ($this->memiliki_varian && $this->varian->count() > 0) {
            $min = $this->harga_jual + $this->varian->min('harga_tambahan');
            $max = $this->harga_jual + $this->varian->max('harga_tambahan');

            if ($min == $max) {
                return 'Rp '.number_format($min, 0, ',', '.');
            }

            return 'Rp '.number_format($min, 0, ',', '.').' - '.number_format($max, 0, ',', '.');
        }

        return 'Rp '.number_format($this->harga_jual, 0, ',', '.');
    }
}
