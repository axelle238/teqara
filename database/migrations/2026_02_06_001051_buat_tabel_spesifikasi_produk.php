<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi Spesifikasi Produk
 * Mendukung kedalaman data teknis untuk unit komputer dan gadget.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spesifikasi_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('label'); // Contoh: 'Prosesor', 'Kapasitas RAM'
            $table->string('nilai'); // Contoh: 'Apple M3 Max', '64GB'
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spesifikasi_produk');
    }
};