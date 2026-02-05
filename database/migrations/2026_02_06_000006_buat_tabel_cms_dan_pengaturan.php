<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Pengaturan Global
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->string('kunci')->primary(); // cth: 'nama_toko', 'pajak_persen'
            $table->text('nilai')->nullable();
            $table->string('tipe')->default('text'); // text, image, boolean, json
            $table->timestamps();
        });

        // Tabel Konten CMS (Banner, Section)
        Schema::create('cms_konten', function (Blueprint $table) {
            $table->id();
            $table->string('bagian'); // cth: 'hero_section', 'promo_banner'
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('url_target')->nullable();
            $table->string('tombol_text')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_konten');
        Schema::dropIfExists('pengaturan');
    }
};
