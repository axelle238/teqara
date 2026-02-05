<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan');
            $table->longText('konten');
            $table->string('gambar_unggulan')->nullable();
            $table->foreignId('penulis_id')->constrained('pengguna')->onDelete('cascade');
            $table->enum('status', ['draft', 'publikasi'])->default('draft');
            $table->integer('jumlah_baca')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
