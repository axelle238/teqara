<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailBerita extends Component
{
    public $berita;

    public function mount($slug)
    {
        $this->berita = Berita::where('slug', $slug)
            ->where('status', 'publikasi')
            ->firstOrFail();
    }

    #[Title('Baca Artikel')]
    public function render()
    {
        // Rekomendasi Produk Terkait (Simulasi berdasarkan keyword judul)
        $keyword = explode(' ', $this->berita->judul)[0];
        $produkTerkait = Produk::where('nama', 'like', "%{$keyword}%")
            ->where('status', 'aktif')
            ->take(3)
            ->get();

        return view('livewire.berita.detail-berita', [
            'produkTerkait' => $produkTerkait,
            'beritaLain' => Berita::where('id', '!=', $this->berita->id)
                ->where('status', 'publikasi')
                ->latest()
                ->take(3)
                ->get()
        ])->layout('components.layouts.app', [
            'title' => $this->berita->judul . ' - Teqara News',
            'deskripsi' => $this->berita->ringkasan
        ]);
    }
}
