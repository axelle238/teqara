<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KunciApi extends Model
{
    use HasFactory;

    protected $table = 'kunci_api';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'pengguna_id',
        'nama_token',
        'token',
        'hak_akses',
        'status',
        'terakhir_dipakai',
    ];

    protected $casts = [
        'hak_akses' => 'array',
        'terakhir_dipakai' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}