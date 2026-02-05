<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PenjualanKilat
 * Tujuan: Event promo penjualan terbatas waktu (Flash Sale) bernarasi Indonesia.
 */
class PenjualanKilat extends Model
{
    use HasFactory;

    protected $table = 'penjualan_kilat';

    protected $guarded = ['id'];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'aktif' => 'boolean',
    ];

    public function produkPenjualanKilat(): HasMany
    {
        return $this->hasMany(ProdukPenjualanKilat::class, 'penjualan_kilat_id');
    }
}
