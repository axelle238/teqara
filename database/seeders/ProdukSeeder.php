<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori
        $katLaptop = Kategori::create([
            'nama' => 'Laptop & Notebook',
            'slug' => 'laptop-notebook',
            'ikon' => 'laptop',
        ]);

        $katHp = Kategori::create([
            'nama' => 'Smartphone',
            'slug' => 'smartphone',
            'ikon' => 'device-phone-mobile',
        ]);

        $katAcc = Kategori::create([
            'nama' => 'Aksesoris',
            'slug' => 'aksesoris',
            'ikon' => 'cpu-chip',
        ]);

        // 2. Buat Merek
        $brandAsus = Merek::create(['nama' => 'ASUS', 'slug' => 'asus', 'logo' => 'asus.png']);
        $brandApple = Merek::create(['nama' => 'Apple', 'slug' => 'apple', 'logo' => 'apple.png']);
        $brandLogitech = Merek::create(['nama' => 'Logitech', 'slug' => 'logitech', 'logo' => 'logitech.png']);

        // 3. Buat Produk
        // Laptop ASUS
        Produk::create([
            'kategori_id' => $katLaptop->id,
            'merek_id' => $brandAsus->id,
            'nama' => 'ASUS ROG Strix G16 (2024)',
            'slug' => Str::slug('ASUS ROG Strix G16 2024'),
            'sku' => 'LPT-ASUS-001',
            'deskripsi_singkat' => 'Laptop Gaming Powerhouse dengan Intel Core i9 dan RTX 4070.',
            'deskripsi_lengkap' => '<p>Dominasi permainan dengan ROG Strix G16 baru, menampilkan prosesor Intel Core i9-13980HX dan GPU NVIDIA GeForce RTX 4070 Laptop.</p>',
            'harga_modal' => 28000000,
            'harga_jual' => 32500000,
            'stok' => 5,
            'status' => 'aktif',
            'gambar_utama' => 'https://dlcdnwebimgs.asus.com/gain/46480749-9359-4299-8E2E-158A5499D508/w750/h470',
        ]);

        // MacBook
        Produk::create([
            'kategori_id' => $katLaptop->id,
            'merek_id' => $brandApple->id,
            'nama' => 'MacBook Pro 14 M3 Pro',
            'slug' => Str::slug('MacBook Pro 14 M3 Pro'),
            'sku' => 'LPT-APPL-001',
            'deskripsi_singkat' => 'Chip M3 Pro yang gahar. Layar Liquid Retina XDR memukau.',
            'deskripsi_lengkap' => '<p>MacBook Pro melesat maju dengan chip M3, M3 Pro, dan M3 Max. Dibuat dengan teknologi 3 nanometer dan menampilkan arsitektur GPU yang benar-benar baru.</p>',
            'harga_modal' => 29000000,
            'harga_jual' => 31999000,
            'stok' => 10,
            'status' => 'aktif',
            'gambar_utama' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp14-spacegray-select-202310?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1697311054290',
        ]);

        // Mouse
        Produk::create([
            'kategori_id' => $katAcc->id,
            'merek_id' => $brandLogitech->id,
            'nama' => 'Logitech MX Master 3S',
            'slug' => Str::slug('Logitech MX Master 3S'),
            'sku' => 'ACC-LOGI-001',
            'deskripsi_singkat' => 'Mouse performa nirkabel ergonomis dengan scrolling ultra-cepat.',
            'deskripsi_lengkap' => '<p>Temui MX Master 3S – mouse ikonik yang dibuat ulang. Rasakan setiap momen alur kerjamu dengan lebih presisi, taktil, dan performa, berkat Klik Tenang dan sensor track-on-glass 8.000 DPI.</p>',
            'harga_modal' => 1200000,
            'harga_jual' => 1650000,
            'stok' => 50,
            'status' => 'aktif',
            'gambar_utama' => 'https://resource.logitech.com/w_692,c_lpad,ar_4:3,q_auto:best,f_auto,dpr_auto/content/dam/logitech/en/products/mice/mx-master-3s/gallery/mx-master-3s-mouse-top-view-graphite.png',
        ]);
    }
}
