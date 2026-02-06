<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('judul');
            $table->string('kategori')->default('umum'); // teknis, billing, akun, dll
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('status', ['terbuka', 'diproses', 'selesai', 'ditutup'])->default('terbuka');
            $table->json('riwayat_pesan')->nullable(); // Array of {sender: 'user'|'admin', message: '...', time: '...'}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_bantuan');
    }
};
