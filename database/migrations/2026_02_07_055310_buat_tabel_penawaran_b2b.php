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
        // 1. Tabel Penawaran Harga (B2B RFQ - Request for Quotation)
        Schema::create('penawaran_harga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->decimal('total_pengajuan', 15, 2)->default(0);
            $table->enum('status', ['pending', 'dibalas', 'disetujui', 'ditolak', 'kadaluarsa'])->default('pending');
            $table->text('pesan_pelanggan')->nullable();
            $table->text('pesan_admin')->nullable();
            $table->timestamp('berlaku_sampai')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });

        // 2. Item Penawaran
        Schema::create('item_penawaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran_harga')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_tawar_satuan', 15, 2)->nullable(); // Harga yang ditawarkan admin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penawaran');
        Schema::dropIfExists('penawaran_harga');
    }
};