<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel pengaturan_sistem Global
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->string('kunci')->primary(); // cth: 'nama_toko', 'pajak_persen'
            $table->text('nilai')->nullable();
            $table->string('tipe')->default('text'); // text, image, boolean, json
            $table->timestamps();
        });

        // Tabel Konten CMS (Banner, Section)
        Schema::create('konten_halaman', function (Blueprint $table) {
            $table->id();
            $table->string('bagian'); // cth: 'hero_section', 'promo_banner'
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('tautan_tujuan')->nullable();
            $table->string('teks_tombol')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten_halaman');
        Schema::dropIfExists('pengaturan_sistem');
    }
};
