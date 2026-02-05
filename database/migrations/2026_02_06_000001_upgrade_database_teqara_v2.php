<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Alamat Pengiriman (Multi-address)
        Schema::create('alamat_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('label_alamat'); // Rumah, Kantor, dll
            $table->string('penerima');
            $table->string('telepon');
            $table->text('alamat_lengkap');
            $table->string('kota');
            $table->string('kode_pos');
            $table->boolean('is_utama')->default(false);
            $table->timestamps();
        });

        // 2. Upgrade Tabel Produk (Hapus kolom yang dipindah, tambah kolom baru)
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['gambar_utama']); // Kita pindah ke tabel gambar_produk
            $table->boolean('memiliki_varian')->default(false)->after('stok');
            $table->decimal('rating_rata_rata', 3, 2)->default(0)->after('status');
        });

        // 3. Tabel Gambar Produk (Gallery)
        Schema::create('gambar_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('url');
            $table->boolean('is_utama')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // 4. Tabel Varian Produk (SKU Management)
        Schema::create('varian_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('nama_varian'); // Contoh: "8GB/256GB - Midnight Black"
            $table->string('sku')->unique();
            $table->decimal('harga_tambahan', 15, 2)->default(0); // Harga tambah dari base price
            $table->integer('stok');
            $table->timestamps();
        });

        // 5. Tabel Spesifikasi Teknis
        Schema::create('spesifikasi_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('judul'); // Processor, RAM, Screen
            $table->string('nilai'); // Intel i9, 32GB, OLED 4K
            $table->timestamps();
        });

        // 6. Tabel Voucher (Marketing)
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('deskripsi')->nullable();
            $table->enum('tipe_diskon', ['persen', 'nominal']);
            $table->decimal('nilai_diskon', 15, 2);
            $table->decimal('min_pembelian', 15, 2)->default(0);
            $table->decimal('maks_potongan', 15, 2)->nullable();
            $table->integer('kuota')->default(0);
            $table->timestamp('berlaku_mulai')->nullable();
            $table->timestamp('berlaku_sampai')->nullable();
            $table->timestamps();
        });

        // 7. Tabel Ulasan (Social Proof)
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade'); // Verifikasi pembelian
            $table->integer('rating'); // 1-5
            $table->text('komentar')->nullable();
            $table->json('foto_ulasan')->nullable();
            $table->timestamps();
        });

        // 8. Tabel Daftar Keinginan (Wishlist)
        Schema::create('daftar_keinginan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_keinginan');
        Schema::dropIfExists('ulasan');
        Schema::dropIfExists('voucher');
        Schema::dropIfExists('spesifikasi_produk');
        Schema::dropIfExists('varian_produk');
        Schema::dropIfExists('gambar_produk');
        Schema::dropIfExists('alamat_pengiriman');

        Schema::table('produk', function (Blueprint $table) {
            $table->string('gambar_utama')->nullable();
            $table->dropColumn(['memiliki_varian', 'rating_rata_rata']);
        });
    }
};
