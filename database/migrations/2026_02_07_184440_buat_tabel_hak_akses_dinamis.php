<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk sistem hak akses dinamis.
     */
    public function up(): void
    {
        // 1. Tabel Peran
        Schema::create('peran', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Administrator, Staf, dll
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 2. Tabel Hak Akses (Fitur/Fungsi)
        Schema::create('hak_akses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fitur'); // Nama manusiawi
            $table->string('kode_rute')->unique(); // pengelola.produk.tambah
            $table->string('grup_modul'); // Produk, Pesanan, dll
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 3. Tabel Pivot Peran Hak Akses
        Schema::create('peran_hak_akses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peran_id')->constrained('peran')->onDelete('cascade');
            $table->foreignId('hak_akses_id')->constrained('hak_akses')->onDelete('cascade');
        });

        // 4. Update Tabel Pengguna (Relasi ke Peran)
        Schema::table('pengguna', function (Blueprint $table) {
            if (Schema::hasColumn('pengguna', 'peran')) {
                // Simpan data lama jika perlu, tapi karena ini upgrade arsitektur, kita tambahkan peran_id
                $table->foreignId('peran_id')->after('peran')->nullable()->constrained('peran')->onDelete('set null');
            }
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropForeign(['peran_id']);
            $table->dropColumn('peran_id');
        });
        Schema::dropIfExists('peran_hak_akses');
        Schema::dropIfExists('hak_akses');
        Schema::dropIfExists('peran');
    }
};