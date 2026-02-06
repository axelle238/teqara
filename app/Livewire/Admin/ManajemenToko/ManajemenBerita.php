<?php

namespace App\Livewire\Admin\ManajemenToko;

use App\Helpers\LogHelper;
use App\Models\Berita;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

/**
 * Class ManajemenBerita
 * Tujuan: Manajemen konten berita dan artikel teknologi untuk pelanggan.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenBerita extends Component
{
    use WithFileUploads, WithPagination;

    // State Halaman
    public $tampilkanForm = false;

    // Properti Model
    public $berita_id;
    public $judul;
    public $ringkasan;
    public $konten;
    public $status = 'draft';
    public $gambar_baru;
    public $gambar_lama;

    // Filter
    public $cari = '';

    protected $rules = [
        'judul' => 'required|min:10',
        'ringkasan' => 'required|max:255',
        'konten' => 'required',
    ];

    protected $messages = [
        'judul.required' => 'Judul artikel wajib diisi.',
        'judul.min' => 'Judul minimal 10 karakter untuk optimasi SEO.',
        'ringkasan.required' => 'Ringkasan singkat wajib diisi.',
        'ringkasan.max' => 'Ringkasan maksimal 255 karakter.',
        'konten.required' => 'Isi artikel tidak boleh kosong.',
    ];

    /**
     * Beralih ke mode tambah artikel (Halaman Penuh).
     */
    public function tambahBaru()
    {
        $this->reset(['berita_id', 'judul', 'ringkasan', 'konten', 'status', 'gambar_baru', 'gambar_lama']);
        $this->tampilkanForm = true;
    }

    /**
     * Beralih ke mode edit artikel (Halaman Penuh).
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $this->berita_id = $berita->id;
        $this->judul = $berita->judul;
        $this->ringkasan = $berita->ringkasan;
        $this->konten = $berita->konten;
        $this->status = $berita->status;
        $this->gambar_lama = $berita->gambar_unggulan;

        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan kembali ke daftar artikel.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['berita_id', 'gambar_baru']);
    }

    /**
     * Menyimpan data berita ke database.
     */
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
            $path = $this->gambar_baru->store('berita', 'public');
            $data['gambar_unggulan'] = '/storage/'.$path;
        }

        if ($this->berita_id) {
            $berita = Berita::find($this->berita_id);
            $berita->update($data);
            $pesan = "Artikel '{$this->judul}' berhasil diperbarui.";
            $aksi = 'update_berita';
        } else {
            Berita::create($data);
            $pesan = "Artikel '{$this->judul}' berhasil dipublikasikan.";
            $aksi = 'create_berita';
        }

        LogHelper::catat($aksi, $this->judul, $pesan, $data);

        $this->tampilkanForm = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->reset(['berita_id', 'gambar_baru']);
    }

    /**
     * Menghapus artikel.
     */
    public function hapus($id)
    {
        $berita = Berita::findOrFail($id);
        $judul = $berita->judul;
        $berita->delete();
        LogHelper::catat('hapus_berita', $judul, "Artikel '{$judul}' telah dihapus.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Artikel berhasil dihapus.']);
    }

    #[Title('Manajemen Berita & Informasi - Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-toko.manajemen-berita', [
            'daftar_berita' => Berita::where('judul', 'like', '%'.$this->cari.'%')->latest()->paginate(10),
        ])->layout('components.layouts.admin');
    }
}