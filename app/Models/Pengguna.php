<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Nama tabel di database.
     */
    protected $table = 'pengguna';

    /**
     * Atribut yang bisa diisi massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran',
        'nomor_telepon',
        'foto_profil',
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast tipe datanya.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_diverifikasi_pada' => 'datetime',
            'kata_sandi' => 'hashed',
        ];
    }

    /**
     * Override nama kolom password untuk otentikasi Laravel.
     */
    public function getAuthPasswordName()
    {
        return 'kata_sandi';
    }
}
