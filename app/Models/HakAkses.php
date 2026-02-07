<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model Hak Akses
 * 
 * Menyimpan daftar fitur dan fungsi sistem yang dapat diotorisasi.
 */
class HakAkses extends Model
{
    use HasFactory;

    protected $table = 'hak_akses';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $guarded = ['id'];

    /**
     * Relasi ke peran yang memiliki hak akses ini.
     */
    public function peran(): BelongsToMany
    {
        return $this->belongsToMany(Peran::class, 'peran_hak_akses', 'hak_akses_id', 'peran_id');
    }
}