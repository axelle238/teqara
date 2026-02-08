<?php

namespace Database\Seeders;

use App\Models\PengaturanSistem;
use Illuminate\Database\Seeder;

class PengaturanSistemSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['kunci' => 'nama_situs', 'nilai' => 'TEQARA', 'tipe' => 'text'],
            ['kunci' => 'deskripsi_situs', 'nilai' => 'Platform Enterprise Commerce solusi pengadaan teknologi hulu ke hilir terpercaya.', 'tipe' => 'text'],
            ['kunci' => 'seo_keywords', 'nilai' => 'komputer, server, workstation, laptop, gadget, enterprise, b2b', 'tipe' => 'text'],
            ['kunci' => 'telepon_dukungan', 'nilai' => '021-555-0199', 'tipe' => 'text'],
            ['kunci' => 'email_dukungan', 'nilai' => 'enterprise@teqara.id', 'tipe' => 'text'],
            ['kunci' => 'alamat_fisik', 'nilai' => 'Menara Teqara Lt. 12, SCBD, Jakarta Selatan', 'tipe' => 'text'],
            ['kunci' => 'sosial_facebook', 'nilai' => 'https://facebook.com/teqara', 'tipe' => 'text'],
            ['kunci' => 'sosial_instagram', 'nilai' => 'https://instagram.com/teqara', 'tipe' => 'text'],
            ['kunci' => 'pajak_ppn', 'nilai' => '11', 'tipe' => 'number'],
        ];

        foreach ($settings as $s) {
            PengaturanSistem::firstOrCreate(
                ['kunci' => $s['kunci']],
                ['nilai' => $s['nilai'], 'tipe' => $s['tipe']]
            );
        }
    }
}