<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaimGaransi extends Model
{
    use HasFactory;

    protected $table = 'klaim_garansi';

    protected $guarded = ['id'];

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    public function seri()
    {
        return $this->belongsTo(ProdukSeri::class, 'produk_seri_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pengguna::class, 'pelanggan_id');
    }
}
