<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use App\Services\LayananStok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

/**
 * Class ManajemenProduk
 * Tujuan: Mengelola inventaris produk komputer dan gadget secara hulu ke hilir.
 */
class ManajemenProduk extends Component
{
    use WithFileUploads, WithPagination;

    // Properti Form
    public $produk_id;

    public $kategori_id;

    public $merek_id;

    public $nama;

    public $kode_unit;

    public $harga_modal;

    public $harga_jual;

    public $stok;

    public $berat_gram;

    public $deskripsi_singkat;

    public $deskripsi_lengkap;

    public $status = 'aktif';

    public $gambar_baru;

    // Filter & Pencarian
    public $cari = '';

    public $filter_kategori = '';

    protected $rules = [
        'nama' => 'required|min:5',
        'kategori_id' => 'required|exists:kategori,id',
        'kode_unit' => 'required|unique:produk,kode_unit',
        'harga_jual' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
    ];

    public function tambahBaru()
    {
        $this->reset(['produk_id', 'kategori_id', 'merek_id', 'nama', 'kode_unit', 'harga_modal', 'harga_jual', 'stok', 'berat_gram', 'deskripsi_singkat', 'deskripsi_lengkap', 'gambar_baru']);
        $this->status = 'aktif';
        $this->dispatch('open-panel-form-produk');
    }

    public function simpan()
    {
        $this->validate();

        $data = [
            'kategori_id' => $this->kategori_id,
            'merek_id' => $this->merek_id,
            'nama' => $this->nama,
            'kode_unit' => $this->kode_unit,
            'harga_modal' => $this->harga_modal,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'berat_gram' => $this->berat_gram ?? 1000,
            'deskripsi_singkat' => $this->deskripsi_singkat,
            'deskripsi_lengkap' => $this->deskripsi_lengkap,
            'status' => $this->status,
        ];

        if ($this->gambar_baru) {
            $path = $this->gambar_baru->store('produk', 'public');
            $data['gambar_utama'] = '/storage/' . $path;
        }

        Produk::create($data);

        if ($this->stok > 0) {
            $layananStok = new LayananStok;
            $layananStok->tambahStok(Produk::latest()->first(), $this->stok, 'Input stok awal produk baru');
        }

        LogHelper::catat(
            'buat_produk',
            $this->nama,
            "Admin menambahkan produk baru: {$this->nama} (kode_unit: {$this->kode_unit})",
            $data
        );

        $this->dispatch('close-panel-form-produk');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Produk {$this->nama} berhasil ditambahkan!"]);
    }

    #[Title('Manajemen Produk - Teqara Admin')]
    public function render()
    {
        $daftar_produk = Produk::query()
            ->with(['kategori', 'merek'])
            ->where('nama', 'like', '%'.$this->cari.'%')
            ->when($this->filter_kategori, fn ($q) => $q->where('kategori_id', $this->filter_kategori))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manajemen-produk.manajemen-produk', [
            'produk' => $daftar_produk,
            'kategori' => Kategori::all(),
            'merek' => Merek::all(),
        ])->layout('components.layouts.admin');
    }
}
