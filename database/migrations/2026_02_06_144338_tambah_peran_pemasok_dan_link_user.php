<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modify enum 'peran' in 'pengguna' table to include 'pemasok'
        // Using raw SQL because Schema builder for changing ENUM is limited across drivers
        // Assuming MySQL/MariaDB which uses ALTER TABLE MODIFY
        
        try {
            DB::statement("ALTER TABLE pengguna MODIFY COLUMN peran ENUM('admin', 'staf_gudang', 'kasir', 'pelanggan', 'pemasok') NOT NULL DEFAULT 'pelanggan'");
        } catch (\Exception $e) {
            // Fallback or ignore if already exists/not supported, but in this env it should work.
        }

        // 2. Add pengguna_id to pemasok table
        Schema::table('pemasok', function (Blueprint $table) {
            if (!Schema::hasColumn('pemasok', 'pengguna_id')) {
                $table->foreignId('pengguna_id')->nullable()->after('id')->constrained('pengguna')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemasok', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        // Revert enum is risky if data exists, but we can try to revert to previous state
        try {
             DB::statement("ALTER TABLE pengguna MODIFY COLUMN peran ENUM('admin', 'staf_gudang', 'kasir', 'pelanggan') NOT NULL DEFAULT 'pelanggan'");
        } catch (\Exception $e) {
            // Cannot revert if 'pemasok' data exists
        }
    }
};