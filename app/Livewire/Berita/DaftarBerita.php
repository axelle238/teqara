<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarBerita
 * Tujuan: Menampilkan daftar artikel, berita, dan informasi teknologi.
 */
class DaftarBerita extends Component
{
    use WithPagination;

    public $cari = '';
    public $kategori = '';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    #[Title('Berita & Artikel - Teqara Hub')]
    public function render()
    {
        $query = Berita::query()
            ->with('penulis')
            ->where('status', 'publikasi');

        if ($this->cari) {
            $query->where('judul', 'like', '%'.$this->cari.'%');
        }

        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }

        $beritaUtama = null;
        if ($this->page == 1 && empty($this->cari) && empty($this->kategori)) {
            $beritaUtama = $query->clone()->latest()->first();
            if ($beritaUtama) {
                $query->where('id', '!=', $beritaUtama->id);
            }
        }

        return view('livewire.berita.daftar-berita', [
            'berita' => $query->latest()->paginate(9),
            'beritaUtama' => $beritaUtama,
            'kategoriList' => Berita::select('kategori')->distinct()->pluck('kategori'),
        ])->layout('components.layouts.app');
    }
}