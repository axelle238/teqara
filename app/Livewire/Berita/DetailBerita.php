<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailBerita extends Component
{
    public $berita;

    public function mount($slug)
    {
        $this->berita = Berita::where('slug', $slug)
            ->where('status', 'publikasi')
            ->with('penulis')
            ->firstOrFail();
            
        // Increment views counter (optional logic for future)
    }

    #[Title('Baca Artikel')]
    public function render()
    {
        $artikelTerkait = Berita::where('kategori', $this->berita->kategori)
            ->where('id', '!=', $this->berita->id)
            ->where('status', 'publikasi')
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.berita.detail-berita', [
            'terkait' => $artikelTerkait
        ])->layout('components.layouts.app', [
            'title' => $this->berita->judul . ' | Teqara Insights'
        ]);
    }
}
