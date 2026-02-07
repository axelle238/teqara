<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarProduk extends Model
{
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'gambar_produk';

    protected $guarded = ['id'];

    protected $casts = ['is_utama' => 'boolean'];
}
