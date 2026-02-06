<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // Buat akun Admin Utama
        Pengguna::factory()->create([
            'nama' => 'Admin Teqara',
            'email' => 'admin@teqara.com',
            'peran' => 'admin',
        ]);

        // Buat 10 akun pelanggan dummy
        Pengguna::factory(10)->create();

        // Seed Data Enterprise (11 Pilar)
        $this->call([
            CmsSeeder::class,
            ProdukSeeder::class,
            TransaksiSeeder::class,
            HrdSeeder::class,
        ]);
    }
}
