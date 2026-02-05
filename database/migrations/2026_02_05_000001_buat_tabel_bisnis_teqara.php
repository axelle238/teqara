<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // 1. MODUL PRODUK (HULU)
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique(); // Untuk SEO URL
            $table->string('ikon')->nullable(); // Class icon atau path gambar
            $table->timestamps();
        });

        Schema::create('merek', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('merek_id')->nullable()->constrained('merek')->onDelete('set null');
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('kode_unit')->unique(); // Stock Keeping Unit
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->decimal('harga_modal', 15, 2)->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->string('gambar_utama')->nullable();
            $table->enum('status', ['aktif', 'arsip', 'habis'])->default('aktif');
            $table->timestamps();
        });

        // 2. MODUL TRANSAKSI (TENGAH)
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur')->unique(); // TRX-20260205-001
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->decimal('total_harga', 15, 2);
            $table->enum('status_pembayaran', ['belum_dibayar', 'menunggu_verifikasi', 'lunas', 'gagal'])->default('belum_dibayar');
            $table->enum('status_pesanan', ['menunggu', 'diproses', 'dikirim', 'selesai', 'batal'])->default('menunggu');
            $table->text('alamat_pengiriman');
            $table->string('bukti_bayar')->nullable();
            $table->string('resi_pengiriman')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->decimal('harga_saat_ini', 15, 2); // Snapshot harga saat beli
            $table->integer('jumlah');
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });

        // 3. MODUL AUDIT (HILIR)
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->string('aksi'); // cth: 'create', 'update', 'delete', 'login'
            $table->string('target'); // cth: 'Produk A', 'Pesanan #123'
            $table->text('pesan_naratif'); // cth: 'Admin mengubah stok produk A'
            $table->json('meta_data')->nullable(); // Data sebelum/sesudah perubahan
            $table->timestamp('waktu')->useCurrent();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('merek');
        Schema::dropIfExists('kategori');
    }
};
