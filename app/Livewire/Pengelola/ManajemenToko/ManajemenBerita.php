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
 * Komponen Manajemen Berita (CMS)
 * 
 * Mengelola publikasi artikel, berita promo, dan tips teknologi untuk halaman depan.
 */
class ManajemenBerita extends Component
{
    use WithPagination, WithFileUploads;

    // Keadaan Tampilan
    public $tampilkanEditor = false;

    // Properti Model
    public $beritaId;
    public $judul;
    public $slug;
    public $kategori = 'berita'; // berita, promo, tips, event
    public $konten;
    public $status = 'draft'; // draft, publikasi, arsip
    public $gambar_sampul;
    public $gambar_lama;
    public $tags;

    // Filter Pencarian
    public $cari = '';

    /**
     * Mempersiapkan editor untuk artikel baru.
     */
    public function tambahBaru()
    {
        $this->reset(['beritaId', 'judul', 'slug', 'kategori', 'konten', 'status', 'gambar_sampul', 'gambar_lama', 'tags']);
        $this->tampilkanEditor = true;
    }

    /**
     * Memuat data artikel ke dalam editor.
     */
    public function edit($id)
    {
        $artikel = Berita::findOrFail($id);
        $this->beritaId = $artikel->id;
        $this->judul = $artikel->judul;
        $this->slug = $artikel->slug;
        $this->kategori = $artikel->kategori;
        $this->konten = $artikel->konten;
        $this->status = $artikel->status;
        $this->gambar_lama = $artikel->gambar_sampul;
        $this->tags = $artikel->tags;
        
        $this->tampilkanEditor = true;
    }

    /**
     * Menutup editor tanpa menyimpan.
     */
    public function batal()
    {
        $this->tampilkanEditor = false;
        $this->reset(['beritaId', 'gambar_sampul']);
    }

    /**
     * Sinkronisasi slug otomatis saat judul diubah.
     */
    public function updatedJudul()
    {
        $this->slug = Str::slug($this->judul);
    }

    /**
     * Menyimpan data artikel (Baru atau Pembaruan) dengan Log Naratif.
     */
    public function simpan()
    {
        $this->validate([
            'judul' => 'required|min:5|max:200',
            'slug' => 'required|unique:berita,slug,' . $this->beritaId,
            'kategori' => 'required',
            'konten' => 'required|min:20',
            'status' => 'required',
        ]);

        $dataBaru = [
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
            $dataBaru['gambar_sampul'] = '/storage/' . $path;
        }

        if ($this->beritaId) {
            $artikel = Berita::find($this->beritaId);
            $dataLama = $artikel->toArray();
            $artikel->update($dataBaru);
            
            LogHelper::catat(
                'Pembaruan Artikel',
                $this->judul,
                "Pengelola memperbarui artikel '{$this->judul}' pada kategori {$this->kategori}.",
                $dataLama,
                $artikel->fresh()->toArray()
            );
            $pesanToast = "Artikel berhasil diperbarui.";
        } else {
            $artikelBaru = Berita::create($dataBaru);
            LogHelper::catat(
                'Publikasi Artikel',
                $this->judul,
                "Pengelola menerbitkan artikel baru berjudul '{$this->judul}' dengan status {$this->status}.",
                null,
                $artikelBaru->toArray()
            );
            $pesanToast = "Artikel baru berhasil diterbitkan.";
        }

        $this->tampilkanEditor = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesanToast]);
    }

    /**
     * Menghapus artikel secara permanen.
     */
    public function hapus($id)
    {
        $artikel = Berita::findOrFail($id);
        $judul = $artikel->judul;
        $dataLama = $artikel->toArray();
        $artikel->delete();
        
        LogHelper::catat(
            'Penghapusan Artikel',
            $judul,
            "Pengelola menghapus artikel '{$judul}' secara permanen dari sistem CMS.",
            $dataLama
        );

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Artikel telah dihapus dari database.']);
    }

    #[Title('Manajemen Berita & Artikel - Teqara CMS')]
    public function render()
    {
        $query = Berita::latest('dibuat_pada');
        
        if ($this->cari) {
            $query->where('judul', 'like', '%' . $this->cari . '%');
        }

        return view('livewire.pengelola.manajemen-toko.manajemen-berita', [
            'berita' => $query->paginate(10)
        ])->layout('components.layouts.admin', ['header' => 'Manajemen Berita']);
    }
}
