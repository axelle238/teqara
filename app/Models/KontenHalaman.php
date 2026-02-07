<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KontenHalaman
 * Tujuan: Manajemen konten visual dinamis pada halaman depan toko.
 */
class KontenHalaman extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'konten_halaman';

    protected $guarded = ['id'];

    protected $casts = [
        'aktif' => 'boolean',
        'dibuat_pada' => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];
}
