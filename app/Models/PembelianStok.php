<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianStok extends Model
{
    use HasFactory;

    protected $table = 'pembelian_stok';

    protected $guarded = ['id'];

    protected $casts = [
        'tgl_beli' => 'date',
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}