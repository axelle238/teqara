<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KontenHalaman;

class KontenHalamanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hero Section
        KontenHalaman::updateOrCreate(
            ['bagian' => 'hero_section'],
            [
                'judul' => 'Masa Depan Komputasi Ada Di Tangan Anda',
                'deskripsi' => 'Nikmati performa tanpa batas dengan jajaran workstation, server, dan gadget high-end terbaru. Solusi enterprise untuk produktivitas maksimal.',
                'gambar' => null, // Nanti bisa diisi URL gambar real
                'tautan_tujuan' => '/katalog',
                'teks_tombol' => 'Jelajahi Sekarang',
                'aktif' => true,
                'urutan' => 1
            ]
        );

        // 2. Fitur Unggulan (3 Item)
        $fitur = [
            [
                'judul' => 'Ekosistem Enterprise',
                'deskripsi' => 'Integrasi penuh hardware dan software untuk skalabilitas bisnis tanpa henti.',
                'gambar' => 'fa-solid fa-network-wired', // Kita pakai kolom gambar untuk simpan class icon
                'urutan' => 1
            ],
            [
                'judul' => 'Keamanan Siber',
                'deskripsi' => 'Perangkat terproteksi dengan standar keamanan militer untuk data sensitif Anda.',
                'gambar' => 'fa-solid fa-shield-halved',
                'urutan' => 2
            ],
            [
                'judul' => 'Layanan Prioritas',
                'deskripsi' => 'Dukungan teknis khusus 24/7 dengan SLA terjamin untuk klien korporat.',
                'gambar' => 'fa-solid fa-headset',
                'urutan' => 3
            ]
        ];

        foreach ($fitur as $f) {
            KontenHalaman::updateOrCreate(
                ['bagian' => 'fitur_unggulan', 'urutan' => $f['urutan']],
                [
                    'judul' => $f['judul'],
                    'deskripsi' => $f['deskripsi'],
                    'gambar' => $f['gambar'],
                    'aktif' => true
                ]
            );
        }

        // 3. CTA Footer
        KontenHalaman::updateOrCreate(
            ['bagian' => 'cta_footer'],
            [
                'judul' => 'Siap Transformasi Digital?',
                'deskripsi' => 'Bergabunglah dengan ribuan perusahaan yang telah mempercayakan infrastruktur IT mereka kepada Teqara.',
                'tautan_tujuan' => '/daftar',
                'teks_tombol' => 'Buat Akun Bisnis',
                'aktif' => true,
                'urutan' => 1
            ]
        );
    }
}