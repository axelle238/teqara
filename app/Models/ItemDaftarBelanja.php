<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDaftarBelanja extends Model
{
    use HasFactory;

    protected $table = 'item_daftar_belanja';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
