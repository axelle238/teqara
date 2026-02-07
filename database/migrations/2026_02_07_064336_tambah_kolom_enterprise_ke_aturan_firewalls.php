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
        Schema::table('aturan_firewalls', function (Blueprint $table) {
            $table->string('user_agent')->nullable()->after('alamat_ip'); // Blokir spesifik browser/bot
            $table->string('negara', 2)->nullable()->after('user_agent'); // Kode negara ISO (misal: CN, RU)
            $table->string('level_ancaman')->default('medium')->after('alasan'); // low, medium, high, critical
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aturan_firewalls', function (Blueprint $table) {
            $table->dropColumn(['user_agent', 'negara', 'level_ancaman']);
        });
    }
};