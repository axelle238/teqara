<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarKategori extends Component
{
    use WithPagination;

    public $nama;

    public $slug;

    public $ikon;

    public $kategoriId;

    public $modeEdit = false;

    protected $rules = [
        'nama' => 'required|min:3|unique:kategori,nama',
        'ikon' => 'nullable',
    ];

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function simpan()
    {
        $this->validate();

        $kategori = Kategori::create([
            'nama' => $this->nama,
            'slug' => $this->slug,
            'ikon' => $this->ikon,
        ]);

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'tambah_kategori',
            'target' => $this->nama,
            'pesan_naratif' => 'Admin berhasil menambahkan kategori baru: '.$this->nama,
            'waktu' => now(),
        ]);

        $this->reset(['nama', 'slug', 'ikon']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kategori berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $this->kategoriId = $id;
        $this->nama = $kategori->nama;
        $this->slug = $kategori->slug;
        $this->ikon = $kategori->ikon;
        $this->modeEdit = true;
    }

    public function perbarui()
    {
        $this->validate([
            'nama' => 'required|min:3|unique:kategori,nama,'.$this->kategoriId,
        ]);

        $kategori = Kategori::find($this->kategoriId);
        $kategori->update([
            'nama' => $this->nama,
            'slug' => $this->slug,
            'ikon' => $this->ikon,
        ]);

        $this->modeEdit = false;
        $this->reset(['nama', 'slug', 'ikon', 'kategoriId']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kategori berhasil diperbarui.']);
    }

    public function hapus($id)
    {
        $kategori = Kategori::findOrFail($id);
        $nama = $kategori->nama;
        $kategori->delete();

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'hapus_kategori',
            'target' => $nama,
            'pesan_naratif' => 'Admin menghapus kategori: '.$nama,
            'waktu' => now(),
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Kategori berhasil dihapus.']);
    }

    #[Title('Manajemen Kategori - Admin')]
    public function render()
    {
        return view('livewire.admin.kategori.daftar-kategori', [
            'daftarKategori' => Kategori::latest()->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
