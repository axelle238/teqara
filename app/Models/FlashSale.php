<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class FlashSale
 * Tujuan: Event promo terbatas waktu untuk meningkatkan volume penjualan.
 */
class FlashSale extends Model
{
    use HasFactory;

    protected $table = 'flash_sale';

    protected $guarded = ['id'];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'aktif' => 'boolean',
    ];

    public function produkFlashSale(): HasMany
    {
        return $this->hasMany(ProdukFlashSale::class, 'flash_sale_id');
    }
}
