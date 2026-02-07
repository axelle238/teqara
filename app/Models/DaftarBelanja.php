<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarBelanja extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'daftar_belanja';

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ItemDaftarBelanja::class, 'daftar_belanja_id');
    }
}
