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

    // Hero Section
    public $hero_judul;

    public $hero_deskripsi;

    public $hero_tombol;

    public $hero_url;

    public $hero_gambar_lama;

    public $hero_gambar_baru;

    public function mount()
    {
        $hero = KontenHalaman::where('bagian', 'hero_section')->first();
        if ($hero) {
            $this->hero_judul = $hero->judul;
            $this->hero_deskripsi = $hero->deskripsi;
            $this->hero_tombol = $hero->teks_tombol;
            $this->hero_url = $hero->tautan_tujuan;
            $this->hero_gambar_lama = $hero->gambar;
        }
    }

    public function simpanHero()
    {
        $this->validate([
            'hero_judul' => 'required|max:255',
            'hero_gambar_baru' => 'nullable|image|max:2048',
        ]);

        $hero = KontenHalaman::where('bagian', 'hero_section')->first();

        $data = [
            'judul' => $this->hero_judul,
            'deskripsi' => $this->hero_deskripsi,
            'teks_tombol' => $this->hero_tombol,
            'tautan_tujuan' => $this->hero_url,
        ];

        if ($this->hero_gambar_baru) {
            $data['gambar'] = $this->hero_gambar_baru->temporaryUrl();
        }

        $hero->update($data);

        LogHelper::catat(
            'update_cms',
            'Hero Section',
            'Admin memperbarui tampilan Hero Section halaman depan.',
            $data
        );

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Tampilan Beranda diperbarui!']);
    }

    #[Title('Editor Visual - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-toko.manajemen-konten')
            ->layout('components.layouts.admin');
    }
}
