<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class DaftarKategori extends Component
{
    public $tampilkanForm = false;
    public $kategoriId;
    public $nama;
    public $slug;
    public $ikon = 'fa-solid fa-layer-group';
    public $deskripsi;

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function tambahBaru()
    {
        $this->reset(['kategoriId', 'nama', 'slug', 'deskripsi']);
        $this->ikon = 'fa-solid fa-layer-group';
        $this->tampilkanForm = true;
    }

    public function edit($id)
    {
        $kat = Kategori::findOrFail($id);
        $this->kategoriId = $kat->id;
        $this->nama = $kat->nama;
        $this->slug = $kat->slug;
        $this->ikon = $kat->ikon ?? 'fa-solid fa-layer-group';
        $this->deskripsi = $kat->deskripsi;
        
        $this->tampilkanForm = true;
    }

    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['kategoriId', 'nama', 'slug', 'deskripsi', 'ikon']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:3|max:100',
            'slug' => 'required|unique:kategori,slug,' . $this->kategoriId,
            'ikon' => 'nullable|string',
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
            'ikon' => $this->ikon,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->kategoriId) {
            Kategori::find($this->kategoriId)->update($data);
            $pesan = 'Kategori berhasil diperbarui.';
            LogHelper::catat('ubah_kategori', $this->nama, "Pengelola memperbarui data kategori {$this->nama}.");
        } else {
            Kategori::create($data);
            $pesan = 'Kategori baru berhasil ditambahkan.';
            LogHelper::catat('buat_kategori', $this->nama, "Pengelola mendaftarkan kategori baru: {$this->nama}.");
        }

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->batal();
    }

    /**
     * Menghapus kategori produk.
     */
    public function hapus($id)
    {
        $k = Kategori::withCount('produk')->findOrFail($id);
        
        if ($k->produk_count > 0) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: Kategori masih memiliki produk aktif.']);
            return;
        }
        
        $nama = $k->nama;
        $k->delete();
        
        LogHelper::catat('hapus_kategori', $nama, "Kategori {$nama} dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kategori berhasil dihapus.']);
    }

    #[Title('Master Kategori - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.kategori.daftar-kategori', [
            'kategori' => Kategori::withCount('produk')->latest('dibuat_pada')->get()
        ])->layout('components.layouts.admin');
    }
}
