<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Builder;
use App\Models\KontenHalaman;
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

    #[Url(as: 'min')]
    public $hargaMin = null;

    #[Url(as: 'max')]
    public $hargaMax = null;

    #[Url(as: 'spek')]
    public $filterSpesifikasi = []; // Format: ['RAM' => ['8GB', '16GB'], 'Warna' => ['Hitam']]

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function resetFilter()
    {
        $this->reset(['cari', 'filterKategori', 'filterMerek', 'urutkan', 'filterStok', 'hargaMin', 'hargaMax', 'filterSpesifikasi']);
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

    /**
     * Mengambil daftar spesifikasi unik yang tersedia untuk filter.
     * Mengelompokkan berdasarkan Judul (Key) dan nilai uniknya.
     */
    public function getOpsiSpesifikasiProperty()
    {
        // Hanya ambil spesifikasi yang relevan dan umum dijadikan filter
        // Batasi untuk performa
        return \App\Models\SpesifikasiProduk::select('judul', 'nilai')
            ->distinct()
            ->get()
            ->groupBy('judul')
            ->map(function ($items) {
                return $items->pluck('nilai')->unique()->values()->all();
            })
            // Filter hanya judul spesifikasi yang umum (bisa disesuaikan)
            ->filter(function($values, $key) {
                return in_array(strtolower($key), ['ram', 'processor', 'penyimpanan', 'warna', 'ukuran', 'os', 'layar']);
            });
    }

    public function getBannerTokoProperty()
    {
        return KontenHalaman::where('bagian', 'promo_banner')
            ->where('aktif', true)
            ->orderBy('urutan')
            ->get();
    }

    public function render()
    {
        $query = Produk::query()
            ->with(['kategori', 'merek', 'gambar'])
            ->where('status', 'aktif');

        if ($this->cari) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%'.$this->cari.'%')
                  ->orWhere('kode_unit', 'like', '%'.$this->cari.'%');
            });
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

        // Filter Spesifikasi Dinamis (Advanced)
        if (! empty($this->filterSpesifikasi)) {
            foreach ($this->filterSpesifikasi as $judul => $nilai) {
                if (!empty($nilai)) {
                    $query->whereHas('spesifikasi', function (Builder $q) use ($judul, $nilai) {
                        $q->where('judul', $judul)
                          ->whereIn('nilai', is_array($nilai) ? $nilai : [$nilai]);
                    });
                }
            }
        }

        if ($this->filterStok) {
            $query->where('stok', '>', 0);
        }

        if ($this->hargaMin) {
            $query->where('harga_jual', '>=', $this->hargaMin);
        }

        if ($this->hargaMax) {
            $query->where('harga_jual', '<=', $this->hargaMax);
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
