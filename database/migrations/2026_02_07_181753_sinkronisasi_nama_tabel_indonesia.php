<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk sinkronisasi nama tabel dan kolom ke Bahasa Indonesia.
     */
    public function up(): void
    {
        // 1. Rename Tabel (Hilangkan Plural 's' dan English)
        if (Schema::hasTable('aturan_firewalls')) {
            Schema::rename('aturan_firewalls', 'aturan_firewall');
        }
        
        if (Schema::hasTable('insiden_keamanans')) {
            Schema::rename('insiden_keamanans', 'insiden_keamanan');
        }
        
        if (Schema::hasTable('item_proyeks')) {
            Schema::rename('item_proyeks', 'item_proyek');
        }
        
        if (Schema::hasTable('kunci_apis')) {
            Schema::rename('kunci_apis', 'kunci_api');
        }
        
        if (Schema::hasTable('log_apis')) {
            Schema::rename('log_apis', 'log_api');
        }
        
        if (Schema::hasTable('proyeks')) {
            Schema::rename('proyeks', 'proyek');
        }
        
        if (Schema::hasTable('tim_members')) {
            Schema::rename('tim_members', 'anggota_tim');
        }

        // 2. Sinkronisasi Kolom (Rename ke Bahasa Indonesia)
        
        // Aturan Firewall
        if (Schema::hasTable('aturan_firewall')) {
            Schema::table('aturan_firewall', function (Blueprint $table) {
                if (Schema::hasColumn('aturan_firewall', 'user_agent')) {
                    $table->renameColumn('user_agent', 'agen_pengguna');
                }
            });
        }

        // Log API
        if (Schema::hasTable('log_api')) {
            Schema::table('log_api', function (Blueprint $table) {
                if (Schema::hasColumn('log_api', 'ip_address')) {
                    $table->renameColumn('ip_address', 'alamat_ip');
                }
            });
        }

        // Proyek
        if (Schema::hasTable('proyek')) {
            Schema::table('proyek', function (Blueprint $table) {
                if (Schema::hasColumn('proyek', 'created_at')) {
                    $table->renameColumn('created_at', 'dibuat_pada');
                }
                if (Schema::hasColumn('proyek', 'updated_at')) {
                    $table->renameColumn('updated_at', 'diperbarui_pada');
                }
            });
        }

        // Item Proyek
        if (Schema::hasTable('item_proyek')) {
            Schema::table('item_proyek', function (Blueprint $table) {
                if (Schema::hasColumn('item_proyek', 'created_at')) {
                    $table->renameColumn('created_at', 'dibuat_pada');
                }
                if (Schema::hasColumn('item_proyek', 'updated_at')) {
                    $table->renameColumn('updated_at', 'diperbarui_pada');
                }
            });
        }

        // Anggota Tim
        if (Schema::hasTable('anggota_tim')) {
            Schema::table('anggota_tim', function (Blueprint $table) {
                if (Schema::hasColumn('anggota_tim', 'created_at')) {
                    $table->renameColumn('created_at', 'dibuat_pada');
                }
                if (Schema::hasColumn('anggota_tim', 'updated_at')) {
                    $table->renameColumn('updated_at', 'diperbarui_pada');
                }
            });
        }
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        // Kebalikan dari up()
        if (Schema::hasTable('aturan_firewall')) {
            Schema::table('aturan_firewall', function (Blueprint $table) {
                if (Schema::hasColumn('aturan_firewall', 'agen_pengguna')) {
                    $table->renameColumn('agen_pengguna', 'user_agent');
                }
            });
            Schema::rename('aturan_firewall', 'aturan_firewalls');
        }

        if (Schema::hasTable('insiden_keamanan')) {
            Schema::rename('insiden_keamanan', 'insiden_keamanans');
        }

        if (Schema::hasTable('item_proyek')) {
            Schema::table('item_proyek', function (Blueprint $table) {
                if (Schema::hasColumn('item_proyek', 'dibuat_pada')) {
                    $table->renameColumn('dibuat_pada', 'created_at');
                }
                if (Schema::hasColumn('item_proyek', 'diperbarui_pada')) {
                    $table->renameColumn('diperbarui_pada', 'updated_at');
                }
            });
            Schema::rename('item_proyek', 'item_proyeks');
        }

        if (Schema::hasTable('kunci_api')) {
            Schema::rename('kunci_api', 'kunci_apis');
        }

        if (Schema::hasTable('log_api')) {
            Schema::table('log_api', function (Blueprint $table) {
                if (Schema::hasColumn('log_api', 'alamat_ip')) {
                    $table->renameColumn('alamat_ip', 'ip_address');
                }
            });
            Schema::rename('log_api', 'log_apis');
        }

        if (Schema::hasTable('proyek')) {
            Schema::table('proyek', function (Blueprint $table) {
                if (Schema::hasColumn('proyek', 'dibuat_pada')) {
                    $table->renameColumn('dibuat_pada', 'created_at');
                }
                if (Schema::hasColumn('proyek', 'diperbarui_pada')) {
                    $table->renameColumn('diperbarui_pada', 'updated_at');
                }
            });
            Schema::rename('proyek', 'proyeks');
        }

        if (Schema::hasTable('anggota_tim')) {
            Schema::table('anggota_tim', function (Blueprint $table) {
                if (Schema::hasColumn('anggota_tim', 'dibuat_pada')) {
                    $table->renameColumn('dibuat_pada', 'created_at');
                }
                if (Schema::hasColumn('anggota_tim', 'diperbarui_pada')) {
                    $table->renameColumn('diperbarui_pada', 'updated_at');
                }
            });
            Schema::rename('anggota_tim', 'tim_members');
        }
    }
};