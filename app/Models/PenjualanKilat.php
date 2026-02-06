<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKilat extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'penjualan_kilat';

    protected $guarded = ['id'];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
        'aktif' => 'boolean',
    ];

    public function detailProduk()
    {
        return $this->hasMany(ProdukPenjualanKilat::class, 'penjualan_kilat_id');
    }
}
