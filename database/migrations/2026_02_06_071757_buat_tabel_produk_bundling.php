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
        Schema::create('produk_bundling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_produk_id'); // Produk Paket
            $table->unsignedBigInteger('child_produk_id');  // Produk Isi
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            $table->foreign('parent_produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->foreign('child_produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
        
        // Menambahkan kolom tipe_produk ke tabel produk untuk membedakan 'fisik', 'digital', atau 'bundle'
        Schema::table('produk', function (Blueprint $table) {
            $table->enum('tipe_produk', ['fisik', 'digital', 'bundle'])->default('fisik')->after('kategori_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_bundling');
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('tipe_produk');
        });
    }
};
