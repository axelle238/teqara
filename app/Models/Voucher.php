<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Voucher
 * Tujuan: Manajemen kode promo dan diskon belanja.
 */
class Voucher extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'voucher';

    protected $guarded = ['id'];

    protected $casts = [
        'berlaku_mulai' => 'datetime',
        'berlaku_sampai' => 'datetime',
    ];
}
