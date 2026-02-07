<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Merek;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class DaftarMerek extends Component
{
    public $tampilkanForm = false;
    public $merekId;
    public $nama;
    public $slug;
    public $deskripsi;

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function tambahBaru()
    {
        $this->reset(['merekId', 'nama', 'slug', 'deskripsi']);
        $this->tampilkanForm = true;
    }

    public function edit($id)
    {
        $mrk = Merek::findOrFail($id);
        $this->merekId = $mrk->id;
        $this->nama = $mrk->nama;
        $this->slug = $mrk->slug;
        $this->deskripsi = $mrk->deskripsi;
        
        $this->tampilkanForm = true;
    }

    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['merekId', 'nama', 'slug', 'deskripsi']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:2|max:100',
            'slug' => 'required|unique:merek,slug,' . $this->merekId,
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->merekId) {
            Merek::find($this->merekId)->update($data);
            $pesan = 'Data brand berhasil diperbarui.';
            LogHelper::catat('ubah_merek', $this->nama, "Pengelola memperbarui data brand {$this->nama}.");
        } else {
            Merek::create($data);
            $pesan = 'Brand baru berhasil didaftarkan.';
            LogHelper::catat('buat_merek', $this->nama, "Pengelola mendaftarkan brand baru: {$this->nama}.");
        }

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->batal();
    }

    /**
     * Menghapus merek produk.
     */
    public function hapus($id)
    {
        $m = Merek::withCount('produk')->findOrFail($id);
        
        if ($m->produk_count > 0) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: Merek masih memiliki produk aktif.']);
            return;
        }
        
        $nama = $m->nama;
        $m->delete();
        
        LogHelper::catat('hapus_merek', $nama, "Merek {$nama} dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Merek berhasil dihapus.']);
    }

    #[Title('Master Merek - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.merek.daftar-merek', [
            'merek' => Merek::withCount('produk')->latest('dibuat_pada')->get()
        ])->layout('components.layouts.admin');
    }
}
