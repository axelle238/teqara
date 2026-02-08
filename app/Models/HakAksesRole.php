<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAksesRole extends Model
{
    use HasFactory;

    protected $table = 'hak_akses_role';

    protected $guarded = ['id'];

    protected $casts = [
        'baca' => 'boolean',
        'tulis' => 'boolean',
        'hapus' => 'boolean',
    ];
}