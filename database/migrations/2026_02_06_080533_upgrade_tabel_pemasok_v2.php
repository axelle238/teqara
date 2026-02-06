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
        Schema::table('pemasok', function (Blueprint $table) {
            // Re-adding columns with safe ordering
            // Check if columns exist before adding, relative to 'nama_perusahaan' or 'id'
            
            if (!Schema::hasColumn('pemasok', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('pemasok', 'npwp')) {
                $table->string('npwp')->nullable()->after('email');
            }
            if (!Schema::hasColumn('pemasok', 'catatan')) {
                $table->text('catatan')->nullable()->after('alamat');
            }
            // Status already exists based on schema dump, skip adding
        });

        if (!Schema::hasTable('kontak_pemasok')) {
            Schema::create('kontak_pemasok', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pemasok_id');
                $table->string('nama');
                $table->string('jabatan')->nullable();
                $table->string('telepon')->nullable();
                $table->string('email')->nullable();
                $table->timestamps();

                $table->foreign('pemasok_id')->references('id')->on('pemasok')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_pemasok');
        Schema::table('pemasok', function (Blueprint $table) {
            $table->dropColumn(['email', 'website', 'npwp', 'catatan', 'status']);
        });
    }
};
