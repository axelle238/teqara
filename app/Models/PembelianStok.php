<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PembelianStok
 * Tujuan: Mencatat Purchase Order (PO) stok dari pemasok ke gudang.
 */
class PembelianStok extends Model
{
    use HasFactory;

    protected $table = 'pembelian_stok';

    protected $guarded = ['id'];

    public function pemasok(): BelongsTo
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_stok_id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }
}
