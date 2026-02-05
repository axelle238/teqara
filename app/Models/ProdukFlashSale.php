<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProdukFlashSale
 * Tujuan: Item produk yang diikutsertakan dalam event Flash Sale.
 */
class ProdukFlashSale extends Model
{
    use HasFactory;

    protected $table = 'produk_flash_sale';

    protected $guarded = ['id'];

    public function flashSale(): BelongsTo
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
