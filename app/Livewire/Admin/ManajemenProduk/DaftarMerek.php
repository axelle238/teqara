<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Merek;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class DaftarMerek extends Component
{
    use WithFileUploads;

    public $merekId;
    public $nama;
    public $slug;
    public $logo_baru;
    
    public $modeEdit = false;

    protected $rules = [
        'nama' => 'required|min:2',
        'logo_baru' => 'nullable|image|max:2048',
    ];

    public function tambah()
    {
        $this->reset(['merekId', 'nama', 'slug', 'logo_baru', 'modeEdit']);
        $this->dispatch('open-slide-over', id: 'form-merek');
    }

    public function edit($id)
    {
        $m = Merek::findOrFail($id);
        $this->merekId = $m->id;
        $this->nama = $m->nama;
        $this->slug = $m->slug;
        $this->modeEdit = true;
        $this->dispatch('open-slide-over', id: 'form-merek');
    }

    public function simpan()
    {
        $this->validate();
        
        $data = [
            'nama' => $this->nama,
            'slug' => \Illuminate\Support\Str::slug($this->nama),
        ];

        if ($this->logo_baru) {
            $path = $this->logo_baru->store('merek', 'public');
            $data['logo'] = $path;
        }

        if ($this->modeEdit) {
            $m = Merek::find($this->merekId);
            $m->update($data);
            $pesan = "Merek {$this->nama} diperbarui.";
            $aksi = 'update_merek';
        } else {
            Merek::create($data);
            $pesan = "Merek {$this->nama} ditambahkan.";
            $aksi = 'buat_merek';
        }

        LogHelper::catat($aksi, $this->nama, $pesan);
        $this->dispatch('close-slide-over', id: 'form-merek');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    public function hapus($id)
    {
        $m = Merek::withCount('produk')->findOrFail($id);
        if ($m->produk_count > 0) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: Merek masih memiliki produk.']);
            return;
        }
        
        $nama = $m->nama;
        $m->delete();
        LogHelper::catat('hapus_merek', $nama, "Merek {$nama} dihapus.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Merek dihapus.']);
    }

    #[Title('Master Merek - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.merek.daftar-merek', [
            'merek' => Merek::withCount('produk')->get()
        ])->layout('components.layouts.admin');
    }
}