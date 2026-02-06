<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPenjualanKilat extends Model
{
    use HasFactory;

    protected $table = 'produk_penjualan_kilat';

    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}