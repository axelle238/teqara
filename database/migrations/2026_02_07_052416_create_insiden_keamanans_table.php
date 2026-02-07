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
        Schema::create('insiden_keamanans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_insiden'); // login_gagal, brute_force, akses_ilegal, sql_injection_attempt
            $table->string('tingkat_keparahan')->default('rendah'); // rendah, sedang, tinggi, kritis
            $table->string('alamat_ip', 45)->nullable();
            $table->foreignId('pengguna_id')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->text('deskripsi')->nullable();
            $table->json('meta_data')->nullable(); // user_agent, payload, url
            $table->timestamp('dibuat_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insiden_keamanans');
    }
};