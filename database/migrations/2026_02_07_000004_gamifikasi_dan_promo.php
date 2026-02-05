<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi v5.0 - Gamifikasi Pelanggan.
     */
    public function up(): void
    {
        // 1. Tambahkan kolom poin & level di tabel pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            $table->integer('poin_loyalitas')->default(0)->after('email');
            $table->string('level_member')->default('Classic')->after('poin_loyalitas'); // Classic, Silver, Gold, Platinum
        });

        // 2. Tabel Riwayat Poin
        Schema::create('riwayat_poin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->integer('jumlah'); // Positif (dapat) atau Negatif (tukar)
            $table->string('sumber'); // 'pembelian', 'ulasan', 'bonus_ultah'
            $table->string('referensi_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Flash Sale
        Schema::create('penjualan_kilat', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('banner_url')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('produk_penjualan_kilat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_kilat_id')->constrained('penjualan_kilat')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->decimal('harga_diskon', 15, 2);
            $table->integer('kuota_stok');
            $table->integer('terjual')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_penjualan_kilat');
        Schema::dropIfExists('penjualan_kilat');
        Schema::dropIfExists('riwayat_poin');

        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['poin_loyalitas', 'level_member']);
        });
    }
};
