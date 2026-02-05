<?php

namespace Database\Seeders;

use App\Models\GambarProduk;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Models\SpesifikasiProduk;
use App\Models\VarianProduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori
        $katLaptop = Kategori::create(['nama' => 'Laptop & Notebook', 'slug' => 'laptop-notebook', 'ikon' => 'laptop']);
        $katHp = Kategori::create(['nama' => 'Smartphone', 'slug' => 'smartphone', 'ikon' => 'device-phone-mobile']);
        $katAcc = Kategori::create(['nama' => 'Aksesoris', 'slug' => 'aksesoris', 'ikon' => 'cpu-chip']);

        // 2. Buat Merek
        $brandAsus = Merek::create(['nama' => 'ASUS', 'slug' => 'asus', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/ASUS_Logo.svg']);
        $brandApple = Merek::create(['nama' => 'Apple', 'slug' => 'apple', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg']);

        // 3. Produk 1: ASUS ROG Strix (Kompleks dengan Varian)
        $p1 = Produk::create([
            'kategori_id' => $katLaptop->id,
            'merek_id' => $brandAsus->id,
            'nama' => 'ASUS ROG Strix G16 (2024)',
            'slug' => Str::slug('ASUS ROG Strix G16 2024'),
            'kode_unit' => 'LPT-ASUS-G16',
            'deskripsi_singkat' => 'Laptop Gaming Powerhouse dengan Intel Core i9 dan RTX 4070.',
            'deskripsi_lengkap' => '<p>Dominasi permainan dengan ROG Strix G16 baru...</p>',
            'harga_modal' => 28000000,
            'harga_jual' => 32500000,
            'stok' => 10,
            'status' => 'aktif',
            'memiliki_varian' => true,
            'rating_rata_rata' => 4.8,
        ]);

        // Gambar
        GambarProduk::create(['produk_id' => $p1->id, 'url' => 'https://dlcdnwebimgs.asus.com/gain/46480749-9359-4299-8E2E-158A5499D508/w750/h470', 'is_utama' => true]);
        GambarProduk::create(['produk_id' => $p1->id, 'url' => 'https://dlcdnwebimgs.asus.com/gain/0f9d6574-d4d3-4e76-836e-587037583389/w750/h470', 'is_utama' => false]);

        // Varian
        VarianProduk::create(['produk_id' => $p1->id, 'nama_varian' => 'RTX 4060 / 16GB / 1TB', 'kode_unit' => 'G16-4060', 'harga_tambahan' => 0, 'stok' => 5]);
        VarianProduk::create(['produk_id' => $p1->id, 'nama_varian' => 'RTX 4070 / 32GB / 2TB', 'kode_unit' => 'G16-4070', 'harga_tambahan' => 5000000, 'stok' => 3]);

        // Spesifikasi
        SpesifikasiProduk::create(['produk_id' => $p1->id, 'judul' => 'Processor', 'nilai' => 'Intel Core i9-13980HX']);
        SpesifikasiProduk::create(['produk_id' => $p1->id, 'judul' => 'GPU', 'nilai' => 'NVIDIA GeForce RTX 40 series']);

        // Produk 2: iPhone 15 Pro (Varian Warna)
        $p2 = Produk::create([
            'kategori_id' => $katHp->id,
            'merek_id' => $brandApple->id,
            'nama' => 'iPhone 15 Pro Max',
            'slug' => Str::slug('iPhone 15 Pro Max'),
            'kode_unit' => 'HP-APPL-15PM',
            'deskripsi_singkat' => 'Titanium. Begitu kuat. Begitu ringan. Begitu Pro.',
            'harga_modal' => 20000000,
            'harga_jual' => 24999000,
            'stok' => 20,
            'status' => 'aktif',
            'memiliki_varian' => true,
            'rating_rata_rata' => 4.9,
        ]);

        GambarProduk::create(['produk_id' => $p2->id, 'url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-max-natural-titanium-select-202309?wid=940&hei=1112&fmt=png-alpha&.v=1693510919706', 'is_utama' => true]);

        VarianProduk::create(['produk_id' => $p2->id, 'nama_varian' => '256GB - Natural Titanium', 'kode_unit' => '15PM-NAT-256', 'harga_tambahan' => 0, 'stok' => 10]);
        VarianProduk::create(['produk_id' => $p2->id, 'nama_varian' => '512GB - Blue Titanium', 'kode_unit' => '15PM-BLU-512', 'harga_tambahan' => 4000000, 'stok' => 5]);
    }
}
