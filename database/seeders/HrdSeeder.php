<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrdSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Departemen
        $deptIds = [];
        $deptIds['IT'] = DB::table('departemen')->insertGetId(['nama' => 'Teknologi Informasi', 'kode' => 'IT', 'created_at' => now()]);
        $deptIds['SALES'] = DB::table('departemen')->insertGetId(['nama' => 'Penjualan & Pemasaran', 'kode' => 'SLS', 'created_at' => now()]);
        $deptIds['GUDANG'] = DB::table('departemen')->insertGetId(['nama' => 'Logistik & Gudang', 'kode' => 'LOG', 'created_at' => now()]);
        $deptIds['HRD'] = DB::table('departemen')->insertGetId(['nama' => 'Human Resources', 'kode' => 'HR', 'created_at' => now()]);

        // 2. Jabatan
        DB::table('jabatan')->insert([
            ['nama' => 'CTO', 'departemen_id' => $deptIds['IT'], 'gaji_pokok' => 25000000, 'created_at' => now()],
            ['nama' => 'Sales Manager', 'departemen_id' => $deptIds['SALES'], 'gaji_pokok' => 15000000, 'created_at' => now()],
            ['nama' => 'Kepala Gudang', 'departemen_id' => $deptIds['GUDANG'], 'gaji_pokok' => 12000000, 'created_at' => now()],
            ['nama' => 'Staff Admin', 'departemen_id' => $deptIds['HRD'], 'gaji_pokok' => 8000000, 'created_at' => now()],
        ]);
    }
}
