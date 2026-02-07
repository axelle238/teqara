<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Anggota Tim
 * 
 * Merepresentasikan anggota tim dalam proyek atau organisasi.
 */
class AnggotaTim extends Model
{
    use HasFactory;

    protected $table = 'anggota_tim';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $guarded = ['id'];
}
