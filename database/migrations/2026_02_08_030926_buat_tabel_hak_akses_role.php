<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Matriks Hak Akses Baru (Role Based)
        Schema::create('hak_akses_role', function (Blueprint $table) {
            $table->id();
            $table->string('peran'); // admin, editor, cs, gudang
            $table->string('modul'); // produk, pesanan, laporan, hrd
            $table->boolean('baca')->default(false);
            $table->boolean('tulis')->default(false);
            $table->boolean('hapus')->default(false);
            $table->timestamps();
        });

        // Patching tabel departemen & jabatan jika belum ada kolomnya
        if (Schema::hasTable('departemen') && !Schema::hasColumn('departemen', 'warna_identitas')) {
            Schema::table('departemen', function (Blueprint $table) {
                $table->string('warna_identitas')->default('#64748b')->after('deskripsi');
            });
        }

        if (Schema::hasTable('jabatan') && !Schema::hasColumn('jabatan', 'level_otoritas')) {
            Schema::table('jabatan', function (Blueprint $table) {
                $table->integer('level_otoritas')->default(1)->after('gaji_pokok');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('hak_akses_role');
    }
};