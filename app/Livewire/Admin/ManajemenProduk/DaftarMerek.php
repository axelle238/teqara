<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Models\LogAktivitas;
use App\Models\Merek;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarMerek
 * Tujuan: Manajemen produsen (Merek) produk untuk mempermudah identifikasi unit.
 */
class DaftarMerek extends Component
{
    use WithPagination;

    public $nama;

    public $slug;

    public $logo;

    public $merekId;

    public $modeEdit = false;

    protected $rules = [
        'nama' => 'required|min:2|unique:merek,nama',
    ];

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function simpan()
    {
        $this->validate();

        Merek::create([
            'nama' => $this->nama,
            'slug' => $this->slug,
            'logo' => $this->logo,
        ]);

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'buat_merek',
            'target' => $this->nama,
            'pesan_naratif' => 'Admin menambahkan merek baru: '.$this->nama,
            'waktu' => now(),
        ]);

        $this->reset(['nama', 'slug', 'logo']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Merek berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $merek = Merek::findOrFail($id);
        $this->merekId = $id;
        $this->nama = $merek->nama;
        $this->slug = $merek->slug;
        $this->logo = $merek->logo;
        $this->modeEdit = true;
    }

    public function perbarui()
    {
        $this->validate([
            'nama' => 'required|min:2|unique:merek,nama,'.$this->merekId,
        ]);

        $merek = Merek::find($this->merekId);
        $merek->update([
            'nama' => $this->nama,
            'slug' => $this->slug,
            'logo' => $this->logo,
        ]);

        $this->modeEdit = false;
        $this->reset(['nama', 'slug', 'logo', 'merekId']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Merek berhasil diperbarui.']);
    }

    public function hapus($id)
    {
        $merek = Merek::findOrFail($id);
        $nama = $merek->nama;
        $merek->delete();

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'hapus_merek',
            'target' => $nama,
            'pesan_naratif' => 'Admin menghapus merek: '.$nama,
            'waktu' => now(),
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Merek berhasil dihapus.']);
    }

    #[Title('Manajemen Merek - Admin')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.merek.daftar-merek', [
            'daftarMerek' => Merek::latest()->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
