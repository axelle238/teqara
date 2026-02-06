<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'keranjang';

    protected $guarded = ['id'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function varian(): BelongsTo
    {
        return $this->belongsTo(VarianProduk::class, 'varian_id');
    }

    public function getHargaSatuanAttribute()
    {
        $hargaDasar = $this->produk->harga_jual;
        
        if ($this->varian_id && $this->varian) {
            return $hargaDasar + $this->varian->harga_tambahan;
        }

        return $hargaDasar;
    }

    public function getSubtotalAttribute()
    {
        return $this->harga_satuan * $this->jumlah;
    }
}
