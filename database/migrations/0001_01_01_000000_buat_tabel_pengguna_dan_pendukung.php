<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // Tabel: pengguna
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('kata_sandi');
            $table->enum('peran', ['admin', 'staf_gudang', 'kasir', 'pelanggan'])->default('pelanggan');
            $table->string('nomor_telepon')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamp('email_diverifikasi_pada')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel: token_reset_sandi
        Schema::create('token_reset_sandi', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('dibuat_pada')->nullable();
        });

        // Tabel: sesi
        Schema::create('sesi', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index(); // Laravel mengharapkan user_id secara default, nanti kita sesuaikan di driver
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi');
        Schema::dropIfExists('token_reset_sandi');
        Schema::dropIfExists('pengguna');
    }
};
