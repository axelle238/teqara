<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Kategori;

use App\Helpers\LogHelper;
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
    public $ikon_baru;
    public $ikon_lama;

    public function mount($id = null)
    {
        if ($id) {
            $k = Kategori::findOrFail($id);
            $this->kategoriId = $k->id;
            $this->nama = $k->nama;
            $this->slug = $k->slug;
            $this->ikon_lama = $k->ikon;
        }
    }

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'ikon_baru' => 'nullable|image|max:1024',
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
        ];

        if ($this->ikon_baru) {
            $data['ikon'] = $this->ikon_baru->store('kategori', 'public');
        }

        if ($this->kategoriId) {
            Kategori::find($this->kategoriId)->update($data);
            $pesan = "Kategori {$this->nama} berhasil diperbarui.";
            $aksi = 'update_kategori';
        } else {
            Kategori::create($data);
            $pesan = "Kategori baru {$this->nama} berhasil dibuat.";
            $aksi = 'buat_kategori';
        }

        LogHelper::catat($aksi, $this->nama, $pesan);
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        return redirect()->route('pengelola.kategori');
    }

    #[Title('Formulir Kategori - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.kategori.form-kategori')
            ->layout('components.layouts.admin');
    }
}
