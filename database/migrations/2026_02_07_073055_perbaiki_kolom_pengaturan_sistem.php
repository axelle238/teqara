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
        Schema::table('pengaturan_sistem', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturan_sistem', 'created_at')) {
                $table->renameColumn('created_at', 'dibuat_pada');
            }
            if (Schema::hasColumn('pengaturan_sistem', 'updated_at')) {
                $table->renameColumn('updated_at', 'diperbarui_pada');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_sistem', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturan_sistem', 'dibuat_pada')) {
                $table->renameColumn('dibuat_pada', 'created_at');
            }
            if (Schema::hasColumn('pengaturan_sistem', 'diperbarui_pada')) {
                $table->renameColumn('diperbarui_pada', 'updated_at');
            }
        });
    }
};