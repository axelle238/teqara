<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class DaftarKategori extends Component
{
    use WithFileUploads;

    public $kategoriId;
    public $nama;
    public $slug;
    public $ikon_baru;
    
    public $modeEdit = false;

    protected $rules = [
        'nama' => 'required|min:3',
        'ikon_baru' => 'nullable|image|max:1024',
    ];

    public function tambah()
    {
        $this->reset(['kategoriId', 'nama', 'slug', 'ikon_baru', 'modeEdit']);
        $this->dispatch('open-slide-over', id: 'form-kategori');
    }

    public function edit($id)
    {
        $k = Kategori::findOrFail($id);
        $this->kategoriId = $k->id;
        $this->nama = $k->nama;
        $this->slug = $k->slug;
        $this->modeEdit = true;
        $this->dispatch('open-slide-over', id: 'form-kategori');
    }

    public function simpan()
    {
        $this->validate();
        
        $data = [
            'nama' => $this->nama,
            'slug' => \Illuminate\Support\Str::slug($this->nama),
        ];

        if ($this->ikon_baru) {
            $path = $this->ikon_baru->store('kategori', 'public');
            $data['ikon'] = $path; // Simpan path relatif
        }

        if ($this->modeEdit) {
            $k = Kategori::find($this->kategoriId);
            $k->update($data);
            $pesan = "Kategori {$this->nama} diperbarui.";
            $aksi = 'update_kategori';
        } else {
            Kategori::create($data);
            $pesan = "Kategori {$this->nama} ditambahkan.";
            $aksi = 'buat_kategori';
        }

        LogHelper::catat($aksi, $this->nama, $pesan);
        $this->dispatch('close-slide-over', id: 'form-kategori');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    public function hapus($id)
    {
        $k = Kategori::withCount('produk')->findOrFail($id);
        if ($k->produk_count > 0) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: Kategori masih memiliki produk.']);
            return;
        }
        
        $nama = $k->nama;
        $k->delete();
        LogHelper::catat('hapus_kategori', $nama, "Kategori {$nama} dihapus.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kategori dihapus.']);
    }

    #[Title('Master Kategori - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.kategori.daftar-kategori', [
            'kategori' => Kategori::withCount('produk')->get()
        ])->layout('components.layouts.admin');
    }
}