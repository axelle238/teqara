<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi v2.2 - Skema Inventaris Enterprise.
     */
    public function up(): void
    {
        // 1. Tabel Gudang
        Schema::create('gudang', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Cth: Gudang Pusat, Toko Utama
            $table->string('lokasi');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // 2. Stok per Gudang
        Schema::create('stok_gudang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudang')->onDelete('cascade');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
            
            $table->unique(['produk_id', 'gudang_id']);
        });

        // 3. Tabel Nomor Seri (Untuk Barang High-End)
        Schema::create('produk_seri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('nomor_seri')->unique();
            $table->enum('status', ['tersedia', 'terjual', 'rusak', 'retur'])->default('tersedia');
            $table->foreignId('detail_pesanan_id')->nullable()->constrained('detail_pesanan')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_seri');
        Schema::dropIfExists('stok_gudang');
        Schema::dropIfExists('gudang');
    }
};
