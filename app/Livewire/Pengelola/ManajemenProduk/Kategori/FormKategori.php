<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Kategori;

use App\Models\Kategori;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class FormKategori extends Component
{
    use WithFileUploads;

    public $kategoriId;
    public $nama;
    public $slug;
    public $ikon; // URL atau class fontawesome (opsional jika pakai gambar)
    public $gambar;
    public $gambar_lama;

    public function mount($id = null)
    {
        if ($id) {
            $k = Kategori::findOrFail($id);
            $this->kategoriId = $k->id;
            $this->nama = $k->nama;
            $this->slug = $k->slug;
            $this->ikon = $k->ikon;
            // $this->gambar_lama = $k->gambar; // Jika ada kolom gambar
        }
    }

    public function updatedNama()
    {
        $this->slug = Str::slug($this->nama);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'slug' => 'required|unique:kategori,slug,'.$this->kategoriId,
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
            'ikon' => $this->ikon
        ];

        if ($this->kategoriId) {
            Kategori::find($this->kategoriId)->update($data);
            $pesan = 'Kategori diperbarui.';
        } else {
            Kategori::create($data);
            $pesan = 'Kategori baru ditambahkan.';
        }

        return redirect()->route('pengelola.kategori')->with('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    #[Title('Form Kategori - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.kategori.form-kategori')
            ->layout('components.layouts.admin');
    }
}
