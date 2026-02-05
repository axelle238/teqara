<?php

namespace App\Livewire\Admin\CMS;

use App\Helpers\LogHelper;
use App\Models\CmsKonten;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

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
        $hero = CmsKonten::where('bagian', 'hero_section')->first();
        if ($hero) {
            $this->hero_judul = $hero->judul;
            $this->hero_deskripsi = $hero->deskripsi;
            $this->hero_tombol = $hero->tombol_text;
            $this->hero_url = $hero->url_target;
            $this->hero_gambar_lama = $hero->gambar;
        }
    }

    public function simpanHero()
    {
        $this->validate([
            'hero_judul' => 'required|max:255',
            'hero_gambar_baru' => 'nullable|image|max:2048',
        ]);

        $hero = CmsKonten::where('bagian', 'hero_section')->first();

        $data = [
            'judul' => $this->hero_judul,
            'deskripsi' => $this->hero_deskripsi,
            'tombol_text' => $this->hero_tombol,
            'url_target' => $this->hero_url,
        ];

        if ($this->hero_gambar_baru) {
            // Simulasi: Gunakan temporaryUrl atau simpan ke storage nyata
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

    #[Title('Manajemen Konten - Admin')]
    public function render()
    {
        return view('livewire.admin.c-m-s.manajemen-konten')
            ->layout('components.layouts.admin');
    }
}
