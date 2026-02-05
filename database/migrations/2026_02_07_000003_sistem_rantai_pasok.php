<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi SCM (Supply Chain Management).
     */
    public function up(): void
    {
        // 1. Tabel Pemasok (Vendor/Principal)
        Schema::create('pemasok', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemasok')->unique(); // SUP-001
            $table->string('nama_perusahaan');
            $table->string('penanggung_jawab');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->enum('status', ['aktif', 'nonaktif', 'blacklist'])->default('aktif');
            $table->timestamps();
        });

        // 2. Tabel Pembelian Stok (Purchase Order Masuk)
        Schema::create('pembelian_stok', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_po')->unique(); // PO-20260207-001
            $table->foreignId('pemasok_id')->constrained('pemasok');
            $table->foreignId('gudang_id')->constrained('gudang'); // Masuk ke gudang mana
            $table->date('tanggal_pesan');
            $table->date('tanggal_terima')->nullable();
            $table->decimal('total_biaya', 15, 2);
            $table->enum('status', ['dipesan', 'diterima', 'batal'])->default('dipesan');
            $table->text('catatan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('pengguna');
            $table->timestamps();
        });

        // 3. Detail Item Pembelian
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_stok_id')->constrained('pembelian_stok')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk');
            $table->integer('jumlah_pesan');
            $table->integer('jumlah_diterima')->default(0);
            $table->decimal('harga_beli_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
        Schema::dropIfExists('pembelian_stok');
        Schema::dropIfExists('pemasok');
    }
};
