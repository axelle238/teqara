<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            route('beranda'),
            route('katalog'),
            route('berita.daftar'),
            route('bantuan'),
            route('tentang-kami'),
            route('login'),
            route('register'),
        ];

        // Produk
        foreach (Produk::where('status', 'aktif')->get() as $produk) {
            $urls[] = route('produk.detail', $produk->slug);
        }

        // Kategori
        foreach (Kategori::all() as $kategori) {
            $urls[] = route('katalog', ['kategori' => $kategori->slug]);
        }

        // Berita
        foreach (Berita::where('status', 'publikasi')->get() as $berita) {
            $urls[] = route('berita.detail', $berita->slug);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>'.$url.'</loc>';
            $xml .= '<lastmod>'.now()->toAtomString().'</lastmod>';
            $xml .= '<changefreq>daily</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }
        
        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }
}
