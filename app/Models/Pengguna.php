<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model Pengguna
 * 
 * Mengelola data autentikasi dan profil pengguna sistem (Admin, Staf, Pelanggan).
 */
class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $guarded = ['id'];

    protected $hidden = ['kata_sandi', 'token_ingat'];

    /**
     * Nama kolom token remember.
     */
    public function getRememberTokenName()
    {
        return 'token_ingat';
    }

    /**
     * Konfigurasi casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_diverifikasi_pada' => 'datetime',
            'kata_sandi' => 'hashed',
        ];
    }

    /**
     * Nama kolom kata sandi.
     */
    public function getAuthPasswordName()
    {
        return 'kata_sandi';
    }

    /**
     * Relasi ke Peran (Sistem Hak Akses Baru).
     */
    public function peranRelasi(): BelongsTo
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    /**
     * Mengecek apakah pengguna memiliki hak akses ke rute tertentu.
     */
    public function memilikiAkses($kodeRute): bool
    {
        // Bypass untuk Super Admin (Peran Lama)
        if ($this->peran === 'admin') {
            return true;
        }

        if (!$this->peranRelasi) {
            return false;
        }

        return $this->peranRelasi->hakAkses()->where('kode_rute', $kodeRute)->exists();
    }

    // --- Relasi Lainnya ---

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Produk::class, 'daftar_keinginan', 'pengguna_id', 'produk_id')
            ->withPivot(['dibuat_pada', 'diperbarui_pada']);
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

    public function kunciApi(): HasMany
    {
        return $this->hasMany(KunciApi::class, 'pengguna_id');
    }
}