<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'proyek';

    protected $guarded = ['id'];

    protected $casts = [
        'mulai_tanggal' => 'date',
        'selesai_tanggal' => 'date',
        'anggaran' => 'decimal:2',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke Item (Bisa produk yang disimpan untuk proyek ini)
    public function items()
    {
        // Asumsi kita menggunakan tabel pivot atau model item proyek
        return $this->hasMany(ItemProyek::class, 'proyek_id');
    }
}