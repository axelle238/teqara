<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBundling extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'produk_bundling';

    protected $guarded = ['id'];

    public function child()
    {
        return $this->belongsTo(Produk::class, 'child_produk_id');
    }
}
