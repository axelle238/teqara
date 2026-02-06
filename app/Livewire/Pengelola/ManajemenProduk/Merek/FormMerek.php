<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Merek;

use App\Helpers\LogHelper;
use App\Models\Merek;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class FormMerek extends Component
{
    use WithFileUploads;

    public $merekId;
    public $nama;
    public $slug;
    public $logo_baru;
    public $logo_lama;

    public function mount($id = null)
    {
        if ($id) {
            $m = Merek::findOrFail($id);
            $this->merekId = $m->id;
            $this->nama = $m->nama;
            $this->slug = $m->slug;
            $this->logo_lama = $m->logo;
        }
    }

    public function updatedNama($value)
    {
        $this->slug = Str::slug($value);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:2',
            'logo_baru' => 'nullable|image|max:1024',
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
        ];

        if ($this->logo_baru) {
            $data['logo'] = $this->logo_baru->store('merek', 'public');
        }

        if ($this->merekId) {
            Merek::find($this->merekId)->update($data);
            $pesan = "Merek {$this->nama} berhasil diperbarui.";
            $aksi = 'update_merek';
        } else {
            Merek::create($data);
            $pesan = "Merek baru {$this->nama} berhasil ditambahkan.";
            $aksi = 'buat_merek';
        }

        LogHelper::catat($aksi, $this->nama, $pesan);
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        return redirect()->route('pengelola.merek');
    }

    #[Title('Formulir Merek - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.merek.form-merek')
            ->layout('components.layouts.admin');
    }
}
