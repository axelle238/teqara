<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProdukPenjualanKilat
 * Tujuan: Item unit yang terdaftar dalam program penjualan kilat.
 */
class ProdukPenjualanKilat extends Model
{
    use HasFactory;

    protected $table = 'produk_penjualan_kilat';

    protected $guarded = ['id'];

    public function penjualanKilat(): BelongsTo
    {
        return $this->belongsTo(PenjualanKilat::class, 'penjualan_kilat_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
