<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Gudang
 * Tujuan: Menyimpan informasi lokasi fisik penyimpanan stok produk.
 */
class Gudang extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'gudang';

    protected $guarded = ['id'];

    public function stokGudang(): HasMany
    {
        return $this->hasMany(StokGudang::class, 'gudang_id');
    }

    public function pembelianStok(): HasMany
    {
        return $this->hasMany(PembelianStok::class, 'gudang_id');
    }
}
