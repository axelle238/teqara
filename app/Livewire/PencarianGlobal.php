<?php

namespace App\Livewire;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PencarianGlobal extends Component
{
    #[Url]
    public $q = '';

    /**
     * Mengambil hasil pencarian yang dikategorikan.
     */
    public function getHasilPencarianProperty()
    {
        if (strlen($this->q) < 3) return collect();

        // Audit Trail: Catat Pencarian (Guna Analitik Business Intelligence)
        if (auth()->check() && !empty($this->q)) {
            \App\Helpers\LogHelper::catat(
                'Pencarian Produk',
                $this->q,
                "Pelanggan '" . auth()->user()->nama . "' melakukan pencarian global dengan kata kunci: '" . $this->q . "'."
            );
        }

        return Produk::with(['kategori', 'merek', 'gambar'])
            ->where('status', 'aktif')
            ->where(function($query) {
                $query->where('nama', 'like', '%' . $this->q . '%')
                    ->orWhere('deskripsi_singkat', 'like', '%' . $this->q . '%')
                    ->orWhere('kode_unit', 'like', '%' . $this->q . '%')
                    ->orWhereHas('kategori', function ($q) {
                        $q->where('nama', 'like', '%' . $this->q . '%');
                    })
                    ->orWhereHas('merek', function ($q) {
                        $q->where('nama', 'like', '%' . $this->q . '%');
                    });
            })
            ->take(30)
            ->get();
    }

    #[Title('Pencarian Intelligence - TEQARA')]
    public function render()
    {
        return view('livewire.pencarian-global')
            ->layout('components.layouts.app');
    }
}
