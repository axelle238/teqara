<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarBerita extends Component
{
    use WithPagination;

    public $kategori = 'semua';

    public $cari = '';

    public function updatedCari()
    {
        $this->resetPage();
    }

    #[Title('Newsroom & Artikel Teknologi - Teqara')]
    public function render()
    {
        $query = Berita::where('status', 'publikasi')
            ->when($this->cari, fn($q) => $q->where('judul', 'like', '%'.$this->cari.'%'))
            ->latest();

        if ($this->kategori !== 'semua') {
            $query->where('kategori', $this->kategori);
        }

        return view('livewire.berita.daftar-berita', [
            'beritaUtama' => $this->cari ? null : Berita::where('status', 'publikasi')->latest()->first(),
            'daftarBerita' => $query->paginate(9)
        ])->layout('components.layouts.app');
    }
}
