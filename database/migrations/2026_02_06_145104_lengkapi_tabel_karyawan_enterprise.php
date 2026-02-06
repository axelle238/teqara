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
        Schema::table('karyawan', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawan', 'nama_lengkap')) {
                $table->string('nama_lengkap')->after('id');
            }
            if (!Schema::hasColumn('karyawan', 'email')) {
                $table->string('email')->unique()->after('nip');
            }
            if (!Schema::hasColumn('karyawan', 'telepon')) {
                $table->string('telepon')->nullable()->after('email');
            }
            if (!Schema::hasColumn('karyawan', 'alamat')) {
                $table->text('alamat')->nullable()->after('telepon');
            }
            if (!Schema::hasColumn('karyawan', 'status')) {
                $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif')->after('status_kerja');
            }
            if (!Schema::hasColumn('karyawan', 'foto')) {
                $table->string('foto')->nullable()->after('nama_lengkap');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'email', 'telepon', 'alamat', 'status', 'foto']);
        });
    }
};