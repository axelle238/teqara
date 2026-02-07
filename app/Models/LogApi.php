<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogApi extends Model
{
    use HasFactory;

    protected $table = 'log_apis';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    protected $fillable = [
        'kunci_api_id',
        'endpoint',
        'metode',
        'ip_address',
        'payload',
        'respons_kode',
        'waktu_eksekusi',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function kunciApi(): BelongsTo
    {
        return $this->belongsTo(KunciApi::class, 'kunci_api_id');
    }
}