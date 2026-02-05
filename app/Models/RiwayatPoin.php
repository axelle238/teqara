<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class RiwayatPoin
 * Tujuan: Log penambahan atau pengurangan poin loyalitas pelanggan.
 */
class RiwayatPoin extends Model
{
    use HasFactory;

    protected $table = 'riwayat_poin';

    protected $guarded = ['id'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
