<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Indexing untuk pencarian dan filter cepat
        Schema::table('produk', function (Blueprint $table) {
            $table->index('nama'); // Pencarian nama
            $table->index('status'); // Filter status aktif
            $table->index('harga_jual'); // Sorting harga
            $table->index('rating_rata_rata'); // Sorting rating
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->index('nomor_invoice'); // Pencarian invoice
            $table->index('status_pesanan'); // Filter status dashboard
            $table->index('created_at'); // Filter tanggal laporan
        });
        
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->index('waktu'); // Sorting log terbaru
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropIndex(['nama', 'status', 'harga_jual', 'rating_rata_rata']);
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropIndex(['nomor_invoice', 'status_pesanan', 'created_at']);
        });
        
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropIndex(['waktu']);
        });
    }
};
