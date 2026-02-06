<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi Sinkronisasi Darurat v16.0
 * Tujuan: Memastikan tabel fisik di database selaras dengan penamaan Bahasa Indonesia.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Periksa dan ganti nama jika masih menggunakan nama lama (Inggris)
        if (Schema::hasTable('cms_konten') && !Schema::hasTable('konten_halaman')) {
            Schema::rename('cms_konten', 'konten_halaman');
        }

        if (Schema::hasTable('pengaturan') && !Schema::hasTable('pengaturan_sistem')) {
            Schema::rename('pengaturan', 'pengaturan_sistem');
        }

        // Periksa kolom jika tabel sudah ada namun kolom masih lama
        if (Schema::hasTable('konten_halaman')) {
            Schema::table('konten_halaman', function (Blueprint $table) {
                if (Schema::hasColumn('konten_halaman', 'url_target')) {
                    $table->renameColumn('url_target', 'tautan_tujuan');
                }
                if (Schema::hasColumn('konten_halaman', 'tombol_text')) {
                    $table->renameColumn('tombol_text', 'teks_tombol');
                }
            });
        }

        if (Schema::hasTable('produk')) {
            Schema::table('produk', function (Blueprint $table) {
                if (Schema::hasColumn('produk', 'sku')) {
                    $table->renameColumn('sku', 'kode_unit');
                }
            });
        }

        if (Schema::hasTable('pesanan')) {
            Schema::table('pesanan', function (Blueprint $table) {
                if (Schema::hasColumn('pesanan', 'nomor_invoice')) {
                    $table->renameColumn('nomor_invoice', 'nomor_faktur');
                }
            });
        }

        // Penjualan Kilat
        if (Schema::hasTable('flash_sale') && !Schema::hasTable('penjualan_kilat')) {
            Schema::rename('flash_sale', 'penjualan_kilat');
        }
        if (Schema::hasTable('produk_flash_sale') && !Schema::hasTable('produk_penjualan_kilat')) {
            Schema::rename('produk_flash_sale', 'produk_penjualan_kilat');
        }

        if (Schema::hasTable('produk_penjualan_kilat')) {
            Schema::table('produk_penjualan_kilat', function (Blueprint $table) {
                if (Schema::hasColumn('produk_penjualan_kilat', 'flash_sale_id')) {
                    $table->renameColumn('flash_sale_id', 'penjualan_kilat_id');
                }
            });
        }
    }

    public function down(): void
    {
        // Tidak diperlukan untuk sinkronisasi satu arah ini
    }
};