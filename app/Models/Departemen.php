<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Departemen
 * Tujuan: Organisasi internal perusahaan (IT, Sales, HRD, dll).
 */
class Departemen extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'departemen';

    protected $guarded = ['id'];

    public function jabatan(): HasMany
    {
        return $this->hasMany(Jabatan::class, 'departemen_id');
    }
}
