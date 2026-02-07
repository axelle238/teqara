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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable()->constrained('pengguna')->onDelete('cascade');
            $table->string('judul');
            $table->text('pesan');
            $table->string('tipe', 20)->default('info'); // info, sukses, peringatan, bahaya
            $table->string('tautan')->nullable();
            $table->json('data_tambahan')->nullable();
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};