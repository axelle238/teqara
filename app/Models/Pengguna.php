<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama', 'email', 'kata_sandi', 'peran', 'nomor_telepon', 'foto_profil',
    ];

    protected $hidden = ['kata_sandi', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_diverifikasi_pada' => 'datetime',
            'kata_sandi' => 'hashed',
        ];
    }

    public function getAuthPasswordName()
    {
        return 'kata_sandi';
    }

    // Relasi Wishlist (Many to Many via tabel daftar_keinginan)
    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Produk::class, 'daftar_keinginan', 'pengguna_id', 'produk_id')->withTimestamps();
    }

    public function alamat(): HasMany
    {
        return $this->hasMany(AlamatPengiriman::class, 'pengguna_id');
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'pengguna_id');
    }

    public function tiketBantuan(): HasMany
    {
        return $this->hasMany(TiketBantuan::class, 'pengguna_id');
    }
}
