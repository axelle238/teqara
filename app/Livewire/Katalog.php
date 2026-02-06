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

    #[Url(as: 'stok')]
    public $filterStok = false;

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function resetFilter()
    {
        $this->reset(['cari', 'filterKategori', 'filterMerek', 'urutkan', 'filterStok']);
        $this->resetPage();
    }

    public function toggleMerek($slug)
    {
        if (in_array($slug, $this->filterMerek)) {
            $this->filterMerek = array_diff($this->filterMerek, [$slug]);
        } else {
            $this->filterMerek[] = $slug;
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Produk::query()->with(['kategori', 'merek', 'gambar']);

        if ($this->cari) {
            $query->where('nama', 'like', '%'.$this->cari.'%');
        }

        if (! empty($this->filterKategori)) {
            $query->whereHas('kategori', function (Builder $q) {
                $filters = is_array($this->filterKategori) ? $this->filterKategori : [$this->filterKategori];
                $q->whereIn('slug', $filters);
            });
        }

        if (! empty($this->filterMerek)) {
            $query->whereHas('merek', function (Builder $q) {
                $filters = is_array($this->filterMerek) ? $this->filterMerek : [$this->filterMerek];
                $q->whereIn('slug', $filters);
            });
        }

        if ($this->filterStok) {
            $query->where('stok', '>', 0);
        }

        switch ($this->urutkan) {
            case 'termurah': $query->orderBy('harga_jual', 'asc');
                break;
            case 'termahal': $query->orderBy('harga_jual', 'desc');
                break;
            case 'rating': $query->orderBy('rating_rata_rata', 'desc');
                break;
            default: $query->latest();
                break;
        }

        return view('livewire.katalog', [
            'produk' => $query->paginate(12),
            'semuaKategori' => Kategori::all(),
            'semuaMerek' => Merek::all(),
        ])->layout('components.layouts.app', ['title' => 'Eksplorasi Teknologi - Teqara']);
    }
}
