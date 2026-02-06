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
        // 1. Link Pemasok ke Akun Pengguna untuk Login B2B
        Schema::table('pemasok', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('id')->constrained('pengguna')->onDelete('set null');
        });

        // 2. Tabel Purchase Order (PO) - Transaksi Admin beli ke Supplier
        Schema::create('pembelian_stok_b2b', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_po')->unique(); // PO-20260206-001
            $table->foreignId('pemasok_id')->constrained('pemasok')->onDelete('cascade');
            $table->foreignId('gudang_tujuan_id')->constrained('gudang')->onDelete('cascade');
            $table->decimal('total_biaya', 15, 2);
            $table->enum('status', ['draft', 'dikirim', 'diproses_supplier', 'dikirim_supplier', 'diterima', 'batal'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_pesan')->useCurrent();
            $table->timestamp('tanggal_diterima')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('pengguna');
            $table->timestamps();
        });

        // 3. Detail Item PO
        Schema::create('detail_pembelian_b2b', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_stok_b2b_id')->constrained('pembelian_stok_b2b')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('jumlah_pesan');
            $table->integer('jumlah_diterima')->default(0);
            $table->decimal('harga_satuan_beli', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian_b2b');
        Schema::dropIfExists('pembelian_stok_b2b');
        Schema::table('pemasok', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });
    }
};