<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Katalog extends Component
{
    use WithPagination;

    #[Url(as: 'cari')]
    public $cari = '';

    #[Url(as: 'kategori')]
    public $filterKategori = [];

    #[Url(as: 'merek')]
    public $filterMerek = [];

    #[Url(as: 'urutkan')]
    public $urutkan = 'terbaru';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function resetFilter()
    {
        $this->reset(['cari', 'filterKategori', 'filterMerek', 'urutkan']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Produk::query()->with(['kategori', 'merek']);

        // Filter Pencarian
        if ($this->cari) {
            $query->where('nama', 'like', '%'.$this->cari.'%');
        }

        // Filter Kategori (Menerima array slug)
        if (! empty($this->filterKategori)) {
            $query->whereHas('kategori', function (Builder $q) {
                // Jika input string tunggal (dari link menu), ubah jadi array
                $filters = is_array($this->filterKategori) ? $this->filterKategori : [$this->filterKategori];
                $q->whereIn('slug', $filters);
            });
        }

        // Filter Merek
        if (! empty($this->filterMerek)) {
            $query->whereHas('merek', function (Builder $q) {
                $filters = is_array($this->filterMerek) ? $this->filterMerek : [$this->filterMerek];
                $q->whereIn('slug', $filters);
            });
        }

        // Pengurutan
        switch ($this->urutkan) {
            case 'termurah':
                $query->orderBy('harga_jual', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga_jual', 'desc');
                break;
            case 'terbaru':
            default:
                $query->latest();
                break;
        }

        return view('livewire.katalog', [
            'produk' => $query->paginate(12),
            'semuaKategori' => Kategori::all(),
            'semuaMerek' => Merek::all(),
        ])->layout('components.layouts.app', ['title' => 'Katalog Produk - Teqara']);
    }
}
