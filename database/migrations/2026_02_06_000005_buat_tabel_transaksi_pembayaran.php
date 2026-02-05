<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->string('kode_pembayaran')->unique(); // Cth: VA Number atau ID Transaksi Gateway
            $table->string('metode_pembayaran'); // bank_transfer, qris, credit_card
            $table->string('provider'); // bca, mandiri, gopay
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('status'); // pending, success, failed, expired
            $table->timestamp('waktu_bayar')->nullable();
            $table->json('payload_gateway')->nullable(); // Simpan respon asli gateway
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_pembayaran');
    }
};
