<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPembayaran extends Model
{
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'transaksi_pembayaran';

    protected $guarded = ['id'];

    protected $casts = [
        'payload_gateway' => 'array',
        'waktu_bayar' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}