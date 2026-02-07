<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Peran
 * 
 * Mengelola tingkatan akses atau peran pengguna (misal: Administrator, Keuangan).
 */
class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $guarded = ['id'];

    /**
     * Relasi ke daftar hak akses (Fitur/Fungsi).
     */
    public function hakAkses(): BelongsToMany
    {
        return $this->belongsToMany(HakAkses::class, 'peran_hak_akses', 'peran_id', 'hak_akses_id');
    }

    /**
     * Relasi ke pengguna yang memiliki peran ini.
     */
    public function pengguna(): HasMany
    {
        return $this->hasMany(Pengguna::class, 'peran_id');
    }
}
