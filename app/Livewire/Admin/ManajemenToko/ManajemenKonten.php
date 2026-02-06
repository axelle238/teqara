<?php

namespace App\Livewire\Admin\ManajemenToko;

use App\Helpers\LogHelper;
use App\Models\KontenHalaman;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class ManajemenKonten
 * Tujuan: Editor visual untuk mengelola konten dinamis halaman depan (CMS).
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenKonten extends Component
{
    use WithFileUploads;

    // State Halaman
    public $tampilkanForm = false;

    // Properti Model
    public $blokTerpilihId;
    public $judul;
    public $bagian = 'promo_banner'; // hero_section, promo_banner, fitur_unggulan
    public $deskripsi;
    public $teks_tombol;
    public $tautan_tujuan;
    public $urutan = 0;
    public $gambar_baru;
    public $gambar_lama;

    /**
     * Beralih ke mode tambah blok (Halaman Penuh).
     */
    public function tambahBlok()
    {
        $this->reset(['blokTerpilihId', 'judul', 'bagian', 'deskripsi', 'teks_tombol', 'tautan_tujuan', 'urutan', 'gambar_baru', 'gambar_lama']);
        $this->tampilkanForm = true;
    }

    /**
     * Beralih ke mode edit blok (Halaman Penuh).
     */
    public function editBlok($id)
    {
        $k = KontenHalaman::findOrFail($id);
        $this->blokTerpilihId = $k->id;
        $this->judul = $k->judul;
        $this->bagian = $k->bagian;
        $this->deskripsi = $k->deskripsi;
        $this->teks_tombol = $k->teks_tombol;
        $this->tautan_tujuan = $k->tautan_tujuan;
        $this->urutan = $k->urutan;
        $this->gambar_lama = $k->gambar;

        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan kembali ke daftar utama.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['blokTerpilihId', 'gambar_baru']);
    }

    /**
     * Menyimpan data blok konten ke database.
     */
    public function simpanBlok()
    {
        $this->validate([
            'judul' => 'required|min:3',
            'bagian' => 'required',
            'gambar_baru' => 'nullable|image|max:2048',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.min' => 'Judul minimal 3 karakter.',
            'bagian.required' => 'Tipe bagian wajib dipilih.',
            'gambar_baru.image' => 'File harus berupa gambar.',
            'gambar_baru.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'judul' => $this->judul,
            'bagian' => $this->bagian,
            'deskripsi' => $this->deskripsi,
            'teks_tombol' => $this->teks_tombol,
            'tautan_tujuan' => $this->tautan_tujuan,
            'urutan' => $this->urutan,
        ];

        if ($this->gambar_baru) {
            $path = $this->gambar_baru->store('cms', 'public');
            $data['gambar'] = '/storage/'.$path;
        }

        if ($this->blokTerpilihId) {
            KontenHalaman::find($this->blokTerpilihId)->update($data);
            $aksi = 'update_konten';
            $pesan = "Blok konten '{$this->judul}' berhasil diperbarui.";
        } else {
            KontenHalaman::create($data);
            $aksi = 'buat_konten';
            $pesan = "Blok konten baru '{$this->judul}' berhasil ditambahkan.";
        }

        LogHelper::catat($aksi, $this->judul, $pesan);
        $this->tampilkanForm = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->reset(['blokTerpilihId', 'gambar_baru']);
    }

    /**
     * Menghapus blok konten.
     */
    public function hapusBlok($id)
    {
        $k = KontenHalaman::findOrFail($id);
        $judul = $k->judul;
        $k->delete();
        LogHelper::catat('hapus_konten', $judul, "Blok konten '{$judul}' telah dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Blok konten berhasil dihapus.']);
    }

    #[Title('Manajemen Konten Visual - Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-toko.manajemen-konten', [
            'daftarKonten' => KontenHalaman::orderBy('bagian')->orderBy('urutan')->get(),
        ])->layout('components.layouts.admin');
    }
}