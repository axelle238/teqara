<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $guarded = ['id'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function transaksiPembayaran(): HasMany
    {
        return $this->hasMany(TransaksiPembayaran::class, 'pesanan_id');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'pesanan_id');
    }

    public function getTotalHargaRupiahAttribute(): string
    {
        return 'Rp '.number_format($this->total_harga, 0, ',', '.');
    }
}
