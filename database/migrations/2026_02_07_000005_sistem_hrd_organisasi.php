<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi V6.0 - Sistem HRD & Organisasi.
     */
    public function up(): void
    {
        // 1. Departemen (Divisi)
        Schema::create('departemen', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // IT, Sales, Gudang, Keuangan
            $table->string('kode')->unique(); // IT-DEV
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 2. Jabatan (Posisi)
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Senior Developer, Staff Gudang
            $table->foreignId('departemen_id')->constrained('departemen')->onDelete('cascade');
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->timestamps();
        });

        // 3. Detail Karyawan (Extensi Pengguna)
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('jabatan_id')->constrained('jabatan');
            $table->string('nip')->unique(); // Nomor Induk Pegawai
            $table->date('tanggal_bergabung');
            $table->enum('status_kerja', ['kontrak', 'tetap', 'magang'])->default('kontrak');
            $table->timestamps();
        });

        // 4. Absensi (Kehadiran)
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('status')->default('hadir'); // hadir, sakit, izin, alpa
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('karyawan');
        Schema::dropIfExists('jabatan');
        Schema::dropIfExists('departemen');
    }
};
