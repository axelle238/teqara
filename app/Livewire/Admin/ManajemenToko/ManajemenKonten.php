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
 */
class ManajemenKonten extends Component
{
    use WithFileUploads;

    public $blokTerpilihId;

    public $judul;

    public $bagian = 'promo_banner'; // hero_section, promo_banner, fitur_unggulan

    public $deskripsi;

    public $teks_tombol;

    public $tautan_tujuan;

    public $urutan = 0;

    public $gambar_baru;

    public $gambar_lama;

    public function tambahBlok()
    {
        $this->reset(['blokTerpilihId', 'judul', 'bagian', 'deskripsi', 'teks_tombol', 'tautan_tujuan', 'urutan', 'gambar_baru', 'gambar_lama']);
        $this->dispatch('open-slide-over', id: 'form-konten');
    }

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

        $this->dispatch('open-slide-over', id: 'form-konten');
    }

    public function simpanBlok()
    {
        $this->validate([
            'judul' => 'required',
            'bagian' => 'required',
            'gambar_baru' => 'nullable|image|max:2048',
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
            $pesan = "Blok konten '{$this->judul}' diperbarui.";
        } else {
            KontenHalaman::create($data);
            $aksi = 'buat_konten';
            $pesan = "Blok konten baru '{$this->judul}' ditambahkan.";
        }

        LogHelper::catat($aksi, $this->judul, $pesan);
        $this->dispatch('close-slide-over', id: 'form-konten');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->reset(['blokTerpilihId', 'gambar_baru']);
    }

    public function hapusBlok($id)
    {
        $k = KontenHalaman::findOrFail($id);
        $k->delete();
        LogHelper::catat('hapus_konten', $k->judul, 'Blok konten dihapus.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Blok konten dihapus.']);
    }

    #[Title('Editor Visual - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-toko.manajemen-konten', [
            'daftarKonten' => KontenHalaman::orderBy('bagian')->orderBy('urutan')->get(),
        ])->layout('components.layouts.admin');
    }
}
