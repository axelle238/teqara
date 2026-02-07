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
        Schema::create('aturan_firewalls', function (Blueprint $table) {
            $table->id();
            $table->string('alamat_ip', 45)->nullable(); // IPv4 or IPv6
            $table->string('tipe_aturan', 20)->default('blokir'); // blokir, izinkan
            $table->string('alasan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->foreignId('dibuat_oleh')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->timestamp('kadaluarsa_pada')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_firewalls');
    }
};