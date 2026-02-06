<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiketBantuan extends Model
{
    use HasFactory;

    protected $table = 'tiket_bantuan';

    protected $guarded = ['id'];

    protected $casts = [
        'riwayat_pesan' => 'array',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
