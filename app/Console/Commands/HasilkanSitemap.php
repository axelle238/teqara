<?php

namespace App\Console\Commands;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class HasilkanSitemap
 * Tujuan: Menghasilkan berkas sitemap.xml untuk keperluan SEO.
 * Peran: Memastikan seluruh halaman produk dan kategori dapat dirayapi oleh mesin pencari.
 */
class HasilkanSitemap extends Command
{
    protected $signature = 'seo:sitemap';

    protected $description = 'Menghasilkan berkas sitemap.xml secara dinamis berdasarkan data database';

    public function handle()
    {
        $this->info('Sedang menghasilkan sitemap.xml...');

        $url_dasar = config('app.url');
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        // 1. Halaman Utama & Statis
        $halaman_statis = ['', '/katalog', '/login'];
        foreach ($halaman_statis as $jalur) {
            $sitemap .= $this->buatEntri($url_dasar.$jalur, '1.0', 'daily');
        }

        // 2. Daftar Produk
        Produk::where('status', 'aktif')->chunk(100, function ($daftar_produk) use (&$sitemap, $url_dasar) {
            foreach ($daftar_produk as $produk) {
                $sitemap .= $this->buatEntri($url_dasar.'/produk/'.$produk->slug, '0.8', 'weekly');
            }
        });

        // 3. Daftar Kategori
        Kategori::all()->each(function ($kategori) use (&$sitemap, $url_dasar) {
            $sitemap .= $this->buatEntri($url_dasar.'/katalog?kategori='.$kategori->slug, '0.6', 'monthly');
        });

        $sitemap .= '</urlset>';

        File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap berhasil dibuat di: '.public_path('sitemap.xml'));
    }

    /**
     * Membuat satu entri XML untuk sitemap.
     */
    private function buatEntri($url, $prioritas, $frekuensi)
    {
        return "\t<url>".PHP_EOL.
               "\t\t<loc>{$url}</loc>".PHP_EOL.
               "\t\t<lastmod>".now()->toAtomString().'</lastmod>'.PHP_EOL.
               "\t\t<changefreq>{$frekuensi}</changefreq>".PHP_EOL.
               "\t\t<priority>{$prioritas}</priority>".PHP_EOL.
               "\t</url>".PHP_EOL;
    }
}
