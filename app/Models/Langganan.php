<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'langganan';

    protected $guarded = ['id'];

    protected $casts = [
        'mulai_pada' => 'date',
        'berakhir_pada' => 'date',
        'tagihan_berikutnya' => 'date',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
