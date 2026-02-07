<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Merek;

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
    public $logo; // Upload
    public $logo_lama;

    public function mount($id = null)
    {
        if ($id) {
            $m = Merek::findOrFail($id);
            $this->merekId = $m->id;
            $this->nama = $m->nama;
            $this->slug = $m->slug;
            // $this->logo_lama = $m->logo; // Jika ada kolom logo
        }
    }

    public function updatedNama()
    {
        $this->slug = Str::slug($this->nama);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:2',
            'slug' => 'required|unique:merek,slug,'.$this->merekId,
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => $this->slug,
        ];

        // Handle upload logo logic here if needed

        if ($this->merekId) {
            Merek::find($this->merekId)->update($data);
            $pesan = 'Data merek diperbarui.';
        } else {
            Merek::create($data);
            $pesan = 'Merek baru ditambahkan.';
        }

        return redirect()->route('pengelola.merek')->with('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    #[Title('Form Merek - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.merek.form-merek')
            ->layout('components.layouts.admin');
    }
}
