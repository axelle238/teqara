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
        // 1. Tambahkan kolom stok_ditahan pada tabel produk untuk pesanan pending
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'stok_ditahan')) {
                $table->integer('stok_ditahan')->default(0)->after('stok');
            }
            if (!Schema::hasColumn('produk', 'berat_gram')) {
                $table->decimal('berat_gram', 10, 2)->default(1000)->after('harga_modal');
            }
        });

        // 2. Tambahkan alasan pembatalan/pengembalian pada pesanan
        Schema::table('pesanan', function (Blueprint $table) {
            if (!Schema::hasColumn('pesanan', 'alasan_pembatalan')) {
                $table->text('alasan_pembatalan')->nullable()->after('status_pesanan');
            }
            if (!Schema::hasColumn('pesanan', 'waktu_pembatalan')) {
                $table->timestamp('waktu_pembatalan')->nullable()->after('resi_pengiriman');
            }
        });

        // 3. Tambahkan tabel mutasi_stok untuk audit trail pergerakan barang
        if (!Schema::hasTable('mutasi_stok')) {
            Schema::create('mutasi_stok', function (Blueprint $table) {
                $table->id();
                $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
                $table->integer('jumlah'); // Positif masuk, Negatif keluar
                $table->string('jenis_mutasi'); // 'masuk_barang', 'penjualan', 'koreksi', 'retur'
                $table->string('referensi_id')->nullable(); // ID Pesanan atau ID Pembelian
                $table->text('keterangan')->nullable();
                $table->foreignId('oleh_pengguna_id')->nullable()->constrained('pengguna');
                $table->timestamps();
                
                $table->index(['produk_id', 'created_at']);
            });
        }
    }

    /**
     * Kembalikan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_stok');

        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['alasan_pembatalan', 'waktu_pembatalan']);
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['stok_ditahan', 'berat_gram']);
        });
    }
};
