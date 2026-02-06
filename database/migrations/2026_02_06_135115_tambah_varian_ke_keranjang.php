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
        Schema::table('keranjang', function (Blueprint $table) {
            $table->foreignId('varian_id')->nullable()->after('produk_id')->constrained('varian_produk')->onDelete('cascade');
        });

        // Update juga tabel detail_pesanan agar invoice mencatat varian
        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->foreignId('varian_id')->nullable()->after('produk_id')->constrained('varian_produk')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropForeign(['varian_id']);
            $table->dropColumn('varian_id');
        });

        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->dropForeign(['varian_id']);
            $table->dropColumn('varian_id');
        });
    }
};
