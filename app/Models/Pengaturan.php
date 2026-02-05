<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pengaturan
 * Tujuan: Konfigurasi global sistem (Nama Toko, Kontak, dll).
 */
class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $primaryKey = 'kunci';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];
}
