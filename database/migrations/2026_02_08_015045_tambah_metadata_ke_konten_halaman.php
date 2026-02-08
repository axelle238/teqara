<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi untuk menambahkan fleksibilitas metadata pada CMS.
 * Mendukung konfigurasi dinamis per elemen konten (Warna, Icon, dll).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konten_halaman', function (Blueprint $table) {
            $table->json('metadata')->nullable()->after('teks_tombol');
        });
    }

    public function down(): void
    {
        Schema::table('konten_halaman', function (Blueprint $table) {
            $table->dropColumn('metadata');
        });
    }
};