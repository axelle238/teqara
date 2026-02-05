<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsKonten
 * Tujuan: Manajemen konten dinamis halaman depan (Hero, Banner, FAQ).
 */
class CmsKonten extends Model
{
    use HasFactory;

    protected $table = 'cms_konten';

    protected $guarded = ['id'];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
