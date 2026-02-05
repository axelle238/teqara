<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pengaturan Dasar
        DB::table('pengaturan')->insertOrIgnore([
            ['kunci' => 'nama_toko', 'nilai' => 'TEQARA Enterprise', 'tipe' => 'text'],
            ['kunci' => 'email_kontak', 'nilai' => 'support@teqara.com', 'tipe' => 'text'],
            ['kunci' => 'nomor_wa', 'nilai' => '6281234567890', 'tipe' => 'text'],
        ]);

        // 2. Hero Section (Slider Utama)
        DB::table('cms_konten')->insertOrIgnore([
            [
                'bagian' => 'hero_section',
                'judul' => 'Definisikan Ulang Standar Teknologi Masa Depan',
                'deskripsi' => 'Platform pengadaan perangkat komputasi high-end tercepat dan terpercaya untuk individu profesional maupun korporasi berskala besar.',
                'gambar' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=2070',
                'url_target' => '/katalog',
                'tombol_text' => 'Mulai Menjelajah',
                'urutan' => 1,
                'aktif' => true,
            ]
        ]);

        // 3. Banner Promo (Tengah Halaman)
        DB::table('cms_konten')->insertOrIgnore([
            [
                'bagian' => 'promo_banner',
                'judul' => 'Upgrade Setup Workstation Anda',
                'deskripsi' => 'Dapatkan diskon hingga 5JT untuk pembelian paket PC Build-up.',
                'gambar' => null,
                'url_target' => '/katalog?kategori=pc-rakitan',
                'tombol_text' => 'Lihat Paket',
                'urutan' => 1,
                'aktif' => true,
            ]
        ]);
    }
}
