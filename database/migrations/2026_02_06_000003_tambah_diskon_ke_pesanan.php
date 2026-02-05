<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->decimal('potongan_diskon', 15, 2)->default(0)->after('total_harga');
            $table->string('kode_voucher')->nullable()->after('potongan_diskon');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['potongan_diskon', 'kode_voucher']);
        });
    }
};
