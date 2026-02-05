<?php

namespace App\Livewire\Admin\Toko;

use App\Helpers\LogHelper;
use App\Models\Berita;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManajemenBerita extends Component
{
    use WithFileUploads, WithPagination;

    public $berita_id;

    public $judul;

    public $ringkasan;

    public $konten;

    public $status = 'draft';

    public $gambar_baru;

    public $cari = '';

    protected $rules = [
        'judul' => 'required|min:10',
        'ringkasan' => 'required|max:255',
        'konten' => 'required',
    ];

    public function tambahBaru()
    {
        $this->reset(['berita_id', 'judul', 'ringkasan', 'konten', 'status', 'gambar_baru']);
        $this->dispatch('open-panel-form-berita');
    }

    public function simpan()
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul),
            'ringkasan' => $this->ringkasan,
            'konten' => $this->konten,
            'status' => $this->status,
            'penulis_id' => auth()->id(),
        ];

        if ($this->gambar_baru) {
            $data['gambar_unggulan'] = $this->gambar_baru->temporaryUrl();
        }

        if ($this->berita_id) {
            $berita = Berita::find($this->berita_id);
            $berita->update($data);
            $pesan = "Berita '{$this->judul}' berhasil diperbarui.";
            $aksi = 'update_berita';
        } else {
            Berita::create($data);
            $pesan = "Berita '{$this->judul}' berhasil dipublikasikan.";
            $aksi = 'create_berita';
        }

        LogHelper::catat($aksi, $this->judul, 'Admin '.auth()->user()->nama." {$pesan}", $data);

        $this->dispatch('close-panel-form-berita');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $this->berita_id = $berita->id;
        $this->judul = $berita->judul;
        $this->ringkasan = $berita->ringkasan;
        $this->konten = $berita->konten;
        $this->status = $berita->status;
        $this->dispatch('open-panel-form-berita');
    }

    #[Title('Manajemen Berita & Info - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.toko.manajemen-berita', [
            'daftar_berita' => Berita::where('judul', 'like', '%'.$this->cari.'%')->latest()->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
