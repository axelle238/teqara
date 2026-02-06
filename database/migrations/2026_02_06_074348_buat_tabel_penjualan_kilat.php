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
        if (!Schema::hasTable('penjualan_kilat')) {
            Schema::create('penjualan_kilat', function (Blueprint $table) {
                $table->id();
                $table->string('nama_campaign');
                $table->dateTime('mulai');
                $table->dateTime('selesai');
                $table->boolean('aktif')->default(true);
                $table->string('banner')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('produk_penjualan_kilat')) {
            Schema::create('produk_penjualan_kilat', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('penjualan_kilat_id');
                $table->unsignedBigInteger('produk_id');
                $table->decimal('harga_diskon', 15, 2);
                $table->integer('kuota_stok')->default(0);
                $table->integer('terjual')->default(0);
                $table->timestamps();

                $table->foreign('penjualan_kilat_id')->references('id')->on('penjualan_kilat')->onDelete('cascade');
                $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_penjualan_kilat');
        Schema::dropIfExists('penjualan_kilat');
    }
};
