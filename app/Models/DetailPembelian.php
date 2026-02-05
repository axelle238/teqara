<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DetailPembelian
 * Tujuan: Rincian item produk dalam satu Purchase Order stok.
 */
class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'detail_pembelian';

    protected $guarded = ['id'];

    public function pembelianStok(): BelongsTo
    {
        return $this->belongsTo(PembelianStok::class, 'pembelian_stok_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
