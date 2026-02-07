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
        Schema::create('log_apis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunci_api_id')->nullable()->constrained('kunci_apis')->onDelete('set null');
            $table->string('endpoint');
            $table->string('metode');
            $table->string('ip_address');
            $table->json('payload')->nullable();
            $table->integer('respons_kode');
            $table->float('waktu_eksekusi')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_apis');
    }
};