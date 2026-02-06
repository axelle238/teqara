<?php

namespace App\Console\Commands;

use App\Models\Berita;
use App\Models\Produk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class BangunSitemapSEO
 * Tujuan: Membangun sitemap XML otomatis untuk rayapan mesin pencari (SEO).
 * Peran: Sinkronisasi rute publik dan konten dinamis hulu-ke-hilir.
 */
class BangunSitemapSEO extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * @var string
     */
    protected $description = 'Membangun sitemap.xml otomatis dalam Bahasa Indonesia.';

    /**
     * Eksekusi perintah sitemap.
     */
    public function handle()
    {
        $this->info('Memulai generasi sitemap enterprise...');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        // 1. Rute Statis Utama
        $ruteStatis = [
            '/',
            '/katalog',
            '/berita',
            '/bantuan',
            '/masuk',
        ];

        foreach ($ruteStatis as $rute) {
            $sitemap .= '  <url>'.PHP_EOL;
            $sitemap .= '    <loc>'.url($rute).'</loc>'.PHP_EOL;
            $sitemap .= '    <lastmod>'.now()->toAtomString().'</lastmod>'.PHP_EOL;
            $sitemap .= '    <changefreq>daily</changefreq>'.PHP_EOL;
            $sitemap .= '    <priority>1.0</priority>'.PHP_EOL;
            $sitemap .= '  </url>'.PHP_EOL;
        }

        // 2. Rute Dinamis Produk
        $produk = Produk::where('status', 'aktif')->get();
        foreach ($produk as $p) {
            $sitemap .= '  <url>'.PHP_EOL;
            $sitemap .= '    <loc>'.url('/produk/'.$p->slug).'</loc>'.PHP_EOL;
            $sitemap .= '    <lastmod>'.$p->updated_at->toAtomString().'</lastmod>'.PHP_EOL;
            $sitemap .= '    <changefreq>weekly</changefreq>'.PHP_EOL;
            $sitemap .= '    <priority>0.8</priority>'.PHP_EOL;
            $sitemap .= '  </url>'.PHP_EOL;
        }

        // 3. Rute Dinamis Berita
        $berita = Berita::where('status', 'publikasi')->get();
        foreach ($berita as $b) {
            $sitemap .= '  <url>'.PHP_EOL;
            $sitemap .= '    <loc>'.url('/berita/'.$b->slug).'</loc>'.PHP_EOL;
            $sitemap .= '    <lastmod>'.$b->updated_at->toAtomString().'</lastmod>'.PHP_EOL;
            $sitemap .= '    <changefreq>monthly</changefreq>'.PHP_EOL;
            $sitemap .= '    <priority>0.6</priority>'.PHP_EOL;
            $sitemap .= '  </url>'.PHP_EOL;
        }

        $sitemap .= '</urlset>';

        File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap berhasil diterbitkan di: public/sitemap.xml');
    }
}