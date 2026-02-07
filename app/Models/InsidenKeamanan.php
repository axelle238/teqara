<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsidenKeamanan extends Model
{
    use HasFactory;

    protected $table = 'insiden_keamanans';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    protected $fillable = [
        'jenis_insiden',
        'tingkat_keparahan',
        'alamat_ip',
        'pengguna_id',
        'deskripsi',
        'meta_data',
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}