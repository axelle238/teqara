<?php

/**
 * Tabel: Migrasi Sinkronisasi Kolom Bahasa Indonesia v17.0
 * Tujuan: Mengubah seluruh kolom sistem bawaan Laravel ke Bahasa Indonesia.
 * Dampak: Memerlukan pemutakhiran pada seluruh Model Eloquent.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        $tabel_umum = [
            'absensi', 'alamat_pengiriman', 'berita', 'daftar_keinginan', 'departemen', 
            'detail_pembelian', 'detail_pembelian_b2b', 'detail_pesanan', 'detail_stock_opname', 
            'gambar_produk', 'gudang', 'jabatan', 'karyawan', 'kategori', 'keranjang', 
            'klaim_garansi', 'kontak_pemasok', 'konten_halaman', 'log_aktivitas', 'merek', 
            'mutasi_stok', 'pemasok', 'pembelian_stok', 'pembelian_stok_b2b', 'pengguna', 
            'penjualan_kilat', 'pesanan', 'produk', 'produk_bundling', 'produk_penjualan_kilat', 
            'produk_seri', 'riwayat_poin', 'spesifikasi_produk', 'stock_opname', 'stok_gudang', 
            'tiket_bantuan', 'transaksi_pembayaran', 'ulasan', 'varian_produk', 'voucher'
        ];

        foreach ($tabel_umum as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'created_at')) {
                    $table->renameColumn('created_at', 'dibuat_pada');
                }
                if (Schema::hasColumn($table->getTable(), 'updated_at')) {
                    $table->renameColumn('updated_at', 'diperbarui_pada');
                }
            });
        }

        // Tabel Khusus: Pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            if (Schema::hasColumn('pengguna', 'remember_token')) {
                $table->renameColumn('remember_token', 'token_ingat');
            }
        });

        // Tabel Khusus: Sesi (Sessions)
        Schema::table('sesi', function (Blueprint $table) {
            if (Schema::hasColumn('sesi', 'user_id')) {
                $table->renameColumn('user_id', 'pengguna_id');
            }
            if (Schema::hasColumn('sesi', 'ip_address')) {
                $table->renameColumn('ip_address', 'alamat_ip');
            }
            if (Schema::hasColumn('sesi', 'user_agent')) {
                $table->renameColumn('user_agent', 'agen_pengguna');
            }
            if (Schema::hasColumn('sesi', 'payload')) {
                $table->renameColumn('payload', 'muatan');
            }
            if (Schema::hasColumn('sesi', 'last_activity')) {
                $table->renameColumn('last_activity', 'aktivitas_terakhir');
            }
        });

        // Tabel Khusus: Kunci Cache
        Schema::table('kunci_cache', function (Blueprint $table) {
            if (Schema::hasColumn('kunci_cache', 'key')) {
                $table->renameColumn('key', 'kunci');
            }
            if (Schema::hasColumn('kunci_cache', 'owner')) {
                $table->renameColumn('owner', 'pemilik');
            }
            if (Schema::hasColumn('kunci_cache', 'expiration')) {
                $table->renameColumn('expiration', 'kedaluwarsa');
            }
        });

        // Tabel Khusus: Penyimpanan Cache
        Schema::table('penyimpanan_cache', function (Blueprint $table) {
            if (Schema::hasColumn('penyimpanan_cache', 'key')) {
                $table->renameColumn('key', 'kunci');
            }
            if (Schema::hasColumn('penyimpanan_cache', 'value')) {
                $table->renameColumn('value', 'nilai');
            }
            if (Schema::hasColumn('penyimpanan_cache', 'expiration')) {
                $table->renameColumn('expiration', 'kedaluwarsa');
            }
        });

        // Tabel Khusus: Token Reset Sandi
        Schema::table('token_reset_sandi', function (Blueprint $table) {
            if (Schema::hasColumn('token_reset_sandi', 'created_at')) {
                $table->renameColumn('created_at', 'dibuat_pada');
            }
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        // Operasi kebalikan jika diperlukan.
    }
};