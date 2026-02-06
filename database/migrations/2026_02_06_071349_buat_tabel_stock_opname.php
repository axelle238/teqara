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
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->id();
            $table->string('kode_so')->unique();
            $table->unsignedBigInteger('gudang_id')->nullable(); // Nullable jika global
            $table->unsignedBigInteger('petugas_id');
            $table->enum('status', ['draft', 'proses', 'selesai', 'batal'])->default('draft');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // FK
            $table->foreign('petugas_id')->references('id')->on('pengguna')->onDelete('cascade');
            // $table->foreign('gudang_id')->references('id')->on('gudang'); // Opsional jika tabel gudang ada
        });

        Schema::create('detail_stock_opname', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_opname_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('stok_sistem');
            $table->integer('stok_fisik')->nullable(); // Nullable saat inisiasi
            $table->integer('selisih')->default(0);
            $table->string('alasan')->nullable();
            $table->timestamps();

            $table->foreign('stock_opname_id')->references('id')->on('stock_opname')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_stock_opname');
        Schema::dropIfExists('stock_opname');
    }
};
