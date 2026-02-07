<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranHarga extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'penawaran_harga';

    protected $guarded = ['id'];

    protected $casts = [
        'dibuat_pada' => 'datetime',
        'berlaku_sampai' => 'datetime',
        'total_pengajuan' => 'decimal:2',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function items()
    {
        return $this->hasMany(ItemPenawaran::class, 'penawaran_id');
    }
}
