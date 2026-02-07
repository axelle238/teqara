<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Berita
 * Tujuan: Menyimpan konten berita, informasi, dan artikel teknologi untuk pelanggan.
 * Peran: Modul informasi publik terintegrasi.
 */
class Berita extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'berita';

    protected $guarded = ['id'];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'penulis_id');
    }

    public function getGambarSampulAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : 'https://placehold.co/1200x600/1e293b/ffffff?text=Teqara+News';
    }
}
