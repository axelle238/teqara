<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('klaim_garansi')) {
            Schema::create('klaim_garansi', function (Blueprint $table) {
                $table->id();
                $table->string('kode_klaim')->unique();
                $table->unsignedBigInteger('produk_seri_id');
                $table->unsignedBigInteger('pelanggan_id')->nullable(); // Bisa walk-in tanpa akun
                $table->enum('jenis_klaim', ['perbaikan', 'tukar_unit', 'refund', 'pengecekan'])->default('perbaikan');
                $table->enum('status', ['menunggu_unit', 'cek_fisik', 'proses_servis', 'siap_ambil', 'selesai', 'ditolak'])->default('menunggu_unit');
                $table->text('keluhan');
                $table->text('solusi')->nullable();
                $table->text('catatan_teknisi')->nullable();
                $table->dateTime('tgl_masuk');
                $table->dateTime('tgl_selesai')->nullable();
                $table->timestamps();

                $table->foreign('produk_seri_id')->references('id')->on('produk_seri')->onDelete('cascade');
                $table->foreign('pelanggan_id')->references('id')->on('pengguna')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klaim_garansi');
    }
};
