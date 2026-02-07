<?php

namespace App\Livewire\Pengelola\ManajemenToko;

use App\Helpers\LogHelper;
use App\Models\Berita;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

/**
 * Class ManajemenBerita
 * Tujuan: CMS (Content Management System) untuk publikasi artikel dan berita promo.
 * Arsitektur: Full Page Editor.
 */
class ManajemenBerita extends Component
{
    use WithPagination, WithFileUploads;

    // State Halaman
    public $tampilkanEditor = false;

    // Properti Model
    public $beritaId;
    public $judul;
    public $slug;
    public $kategori = 'berita'; // berita, promo, tips, event
    public $konten; // Rich Text (HTML)
    public $status = 'draft'; // draft, publikasi, arsip
    public $gambar_sampul;
    public $gambar_lama;
    public $tags; // Comma separated

    // Filter
    public $cari = '';

    public function tambahBaru()
    {
        $this->reset(['beritaId', 'judul', 'slug', 'kategori', 'konten', 'status', 'gambar_sampul', 'gambar_lama', 'tags']);
        $this->tampilkanEditor = true;
    }

    public function edit($id)
    {
        $b = Berita::findOrFail($id);
        $this->beritaId = $b->id;
        $this->judul = $b->judul;
        $this->slug = $b->slug;
        $this->kategori = $b->kategori;
        $this->konten = $b->konten;
        $this->status = $b->status;
        $this->gambar_lama = $b->gambar_sampul;
        $this->tags = $b->tags;
        
        $this->tampilkanEditor = true;
    }

    public function batal()
    {
        $this->tampilkanEditor = false;
        $this->reset(['beritaId', 'gambar_sampul']);
    }

    public function updatedJudul()
    {
        $this->slug = Str::slug($this->judul);
    }

    public function simpan()
    {
        $this->validate([
            'judul' => 'required|min:5|max:200',
            'slug' => 'required|unique:berita,slug,' . $this->beritaId,
            'kategori' => 'required',
            'konten' => 'required|min:20',
            'status' => 'required',
        ]);

        $data = [
            'judul' => $this->judul,
            'slug' => $this->slug,
            'kategori' => $this->kategori,
            'konten' => $this->konten,
            'status' => $this->status,
            'tags' => $this->tags,
            'penulis_id' => auth()->id(),
        ];

        if ($this->gambar_sampul) {
            $path = $this->gambar_sampul->store('berita', 'public');
            $data['gambar_sampul'] = '/storage/' . $path;
        }

        if ($this->beritaId) {
            Berita::find($this->beritaId)->update($data);
            $aksi = 'update_berita';
            $pesan = "Artikel berhasil diperbarui.";
        } else {
            Berita::create($data);
            $aksi = 'buat_berita';
            $pesan = "Artikel baru berhasil diterbitkan.";
        }

        LogHelper::catat($aksi, $this->judul, "Admin mengelola konten artikel: {$this->judul}");
        
        $this->tampilkanEditor = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    public function hapus($id)
    {
        $b = Berita::findOrFail($id);
        $judul = $b->judul;
        $b->delete();
        
        LogHelper::catat('hapus_berita', $judul, "Artikel dihapus dari CMS.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Artikel dihapus.']);
    }

    #[Title('Manajemen Konten (CMS) - Teqara Admin')]
    public function render()
    {
        $query = Berita::latest('dibuat_pada');
        
        if ($this->cari) {
            $query->where('judul', 'like', '%' . $this->cari . '%');
        }

        return view('livewire.pengelola.manajemen-toko.manajemen-berita', [
            'berita' => $query->paginate(10)
        ])->layout('components.layouts.admin', ['header' => 'Content Management System']);
    }
}
