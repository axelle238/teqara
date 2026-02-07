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
        // Alamat pengiriman needs province and city IDs for RajaOngkir
        if (Schema::hasTable('alamat_pengiriman')) {
            Schema::table('alamat_pengiriman', function (Blueprint $table) {
                if (!Schema::hasColumn('alamat_pengiriman', 'provinsi_id')) {
                    $table->string('provinsi_id')->nullable()->after('alamat_lengkap');
                }
                if (!Schema::hasColumn('alamat_pengiriman', 'kota_id')) {
                    $table->string('kota_id')->nullable()->after('provinsi_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alamat_pengiriman', function (Blueprint $table) {
            $table->dropColumn(['provinsi_id', 'kota_id']);
        });
    }
};
