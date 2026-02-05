<?php

namespace App\Console\Commands;

use App\Models\Produk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class HasilkanSitemapSEO extends Command
{
    /**
     * Nama dan tanda perintah konsol.
     *
     * @var string
     */
    protected $signature = 'seo:sitemap';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Menghasilkan berkas sitemap.xml untuk optimasi SEO';

    /**
     * Jalankan perintah konsol.
     */
    public function handle()
    {
        $this->info('Sedang menghasilkan sitemap.xml...');

        $baseUrl = config('app.url');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        // 1. URL Statis
        $xml .= $this->buatUrlTag($baseUrl, now(), 'daily', '1.0');
        $xml .= $this->buatUrlTag($baseUrl.'/katalog', now(), 'daily', '0.8');

        // 2. URL Produk Dinamis
        $produk = Produk::where('status', 'aktif')->get();
        foreach ($produk as $p) {
            $xml .= $this->buatUrlTag($baseUrl.'/produk/'.$p->slug, $p->updated_at, 'weekly', '0.6');
        }

        $xml .= '</urlset>';

        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap berhasil dibuat di: '.public_path('sitemap.xml'));
    }

    private function buatUrlTag($url, $lastMod, $freq, $priority)
    {
        $tag = '  <url>'.PHP_EOL;
        $tag .= '    <loc>'.htmlspecialchars($url).'</loc>'.PHP_EOL;
        $tag .= '    <lastmod>'.$lastMod->format('Y-m-d').'</lastmod>'.PHP_EOL;
        $tag .= '    <changefreq>'.$freq.'</changefreq>'.PHP_EOL;
        $tag .= '    <priority>'.$priority.'</priority>'.PHP_EOL;
        $tag .= '  </url>'.PHP_EOL;

        return $tag;
    }
}
