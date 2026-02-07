<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom saldo dan loyalitas untuk kelengkapan dasbor.
     */
    public function up(): void
    {
        // 1. Update Tabel Pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            if (!Schema::hasColumn('pengguna', 'saldo_digital')) {
                $table->decimal('saldo_digital', 15, 2)->default(0)->after('poin_loyalitas');
            }
        });

        // 2. Pastikan Tabel Voucher Lengkap
        if (Schema::hasTable('voucher')) {
            Schema::table('voucher', function (Blueprint $table) {
                if (!Schema::hasColumn('voucher', 'aktif')) {
                    $table->boolean('aktif')->default(true)->after('kuota');
                }
            });
        }
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn('saldo_digital');
        });
        
        if (Schema::hasTable('voucher')) {
            Schema::table('voucher', function (Blueprint $table) {
                $table->dropColumn('aktif');
            });
        }
    }
};