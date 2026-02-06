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
        // Karena tabel pemasok sudah dibuat di migrasi sebelumnya, kita skip atau pastikan aman.
        // Asumsikan tabel pemasok sudah ada dari step sebelumnya (kunci-produk-vendor).
        // Kita fokus ke pembelian_stok dan detail_pembelian.

        if (!Schema::hasTable('pembelian_stok')) {
            Schema::create('pembelian_stok', function (Blueprint $table) {
                $table->id();
                $table->string('no_faktur')->unique();
                $table->unsignedBigInteger('pemasok_id');
                $table->unsignedBigInteger('gudang_id')->nullable();
                $table->decimal('total_biaya', 15, 2);
                $table->enum('status', ['draft', 'selesai', 'batal'])->default('draft');
                $table->date('tgl_beli');
                $table->timestamps();

                $table->foreign('pemasok_id')->references('id')->on('pemasok')->onDelete('cascade');
                // $table->foreign('gudang_id')->references('id')->on('gudang');
            });
        }

        if (!Schema::hasTable('detail_pembelian')) {
            Schema::create('detail_pembelian', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pembelian_id');
                $table->unsignedBigInteger('produk_id');
                $table->decimal('harga_beli', 15, 2);
                $table->integer('jumlah');
                $table->decimal('subtotal', 15, 2);
                $table->timestamps();

                $table->foreign('pembelian_id')->references('id')->on('pembelian_stok')->onDelete('cascade');
                $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
        Schema::dropIfExists('pembelian_stok');
    }
};
