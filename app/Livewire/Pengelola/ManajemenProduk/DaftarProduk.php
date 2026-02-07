<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarProduk
 * Tujuan: Katalog Produk Enterprise dengan filter multi-dimensi dan manajemen stok visual.
 */
class DaftarProduk extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $cari = '';

    #[Url(history: true)]
    public $filterKategori = '';

    #[Url(history: true)]
    public $filterMerek = '';

    #[Url(history: true)]
    public $filterStatus = '';

    #[Url(history: true)]
    public $sortField = 'dibuat_pada';

    #[Url(history: true)]
    public $sortDirection = 'desc';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function hapus($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            $nama = $produk->nama;
            $produk->delete();
            
            LogHelper::catat('hapus_produk', $nama, "Menghapus produk dari katalog.");
            $this->dispatch('notifikasi', [
                'tipe' => 'sukses',
                'pesan' => "Produk $nama berhasil dihapus dari katalog.",
            ]);
        }
    }

    public function toggleStatus($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            $statusBaru = $produk->status === 'aktif' ? 'nonaktif' : 'aktif';
            $produk->update(['status' => $statusBaru]);
            
            LogHelper::catat('update_status_produk', $produk->nama, "Mengubah status produk menjadi $statusBaru.");
            $this->dispatch('notifikasi', [
                'tipe' => 'sukses',
                'pesan' => "Status produk diperbarui.",
            ]);
        }
    }

    #[Title('Katalog Produk Enterprise - Teqara')]
    public function render()
    {
        $produk = Produk::query()
            ->with(['kategori', 'merek'])
            ->when($this->cari, function ($q) {
                $q->where(function($sub) {
                    $sub->where('nama', 'like', '%'.$this->cari.'%')
                        ->orWhere('kode_unit', 'like', '%'.$this->cari.'%');
                });
            })
            ->when($this->filterKategori, fn($q) => $q->where('kategori_id', $this->filterKategori))
            ->when($this->filterMerek, fn($q) => $q->where('merek_id', $this->filterMerek))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.daftar-produk', [
            'data_produk' => $produk,
            'kategori_list' => Kategori::orderBy('nama')->get(),
            'merek_list' => Merek::orderBy('nama')->get(),
        ])->layout('components.layouts.admin');
    }
}
