<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Jabatan
 * Tujuan: Definisi posisi kerja dalam sebuah departemen.
 */
class Jabatan extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'jabatan';

    protected $guarded = ['id'];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'jabatan_id');
    }
}
