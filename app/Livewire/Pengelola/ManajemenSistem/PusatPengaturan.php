<?php

namespace App\Livewire\Pengelola\ManajemenSistem;

use App\Services\LayananPengaturan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Komponen Pusat Pengaturan
 * 
 * Antarmuka terpadu untuk mengelola seluruh konfigurasi dinamis aplikasi.
 * Mendukung perubahan logo, SEO, kontak, dan mode pemeliharaan secara real-time.
 */
class PusatPengaturan extends Component
{
    use WithFileUploads;

    public $tabAktif = 'umum'; // umum, tampilan, kontak, seo

    // Properti Konfigurasi
    public $nama_situs;
    public $deskripsi_situs;
    public $logo_url;
    public $favicon_url;
    public $alamat_fisik;
    public $email_dukungan;
    public $telepon_dukungan;
    public $sosial_facebook;
    public $sosial_instagram;
    public $sosial_twitter;
    public $seo_keywords;
    public $seo_description;
    
    // Uploads
    public $logo_baru;
    public $favicon_baru;

    public function mount(LayananPengaturan $layanan)
    {
        $data = $layanan->ambilSemua();
        
        $this->nama_situs = $data['nama_situs'] ?? 'Teqara';
        $this->deskripsi_situs = $data['deskripsi_situs'] ?? '';
        $this->logo_url = $data['logo_url'] ?? '';
        $this->favicon_url = $data['favicon_url'] ?? '';
        $this->alamat_fisik = $data['alamat_fisik'] ?? '';
        $this->email_dukungan = $data['email_dukungan'] ?? '';
        $this->telepon_dukungan = $data['telepon_dukungan'] ?? '';
        $this->sosial_facebook = $data['sosial_facebook'] ?? '';
        $this->sosial_instagram = $data['sosial_instagram'] ?? '';
        $this->sosial_twitter = $data['sosial_twitter'] ?? '';
        $this->seo_keywords = $data['seo_keywords'] ?? '';
        $this->seo_description = $data['seo_description'] ?? '';
    }

    public function gantiTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function simpan(LayananPengaturan $layanan)
    {
        $dataSimpan = [
            'nama_situs' => $this->nama_situs,
            'deskripsi_situs' => $this->deskripsi_situs,
            'alamat_fisik' => $this->alamat_fisik,
            'email_dukungan' => $this->email_dukungan,
            'telepon_dukungan' => $this->telepon_dukungan,
            'sosial_facebook' => $this->sosial_facebook,
            'sosial_instagram' => $this->sosial_instagram,
            'sosial_twitter' => $this->sosial_twitter,
            'seo_keywords' => $this->seo_keywords,
            'seo_description' => $this->seo_description,
        ];

        // Handle File Uploads
        if ($this->logo_baru) {
            $url = $layanan->uploadGambar($this->logo_baru, 'logo_url');
            if ($url) $this->logo_url = $url;
        }

        if ($this->favicon_baru) {
            $url = $layanan->uploadGambar($this->favicon_baru, 'favicon_url');
            if ($url) $this->favicon_url = $url;
        }

        $layanan->simpanBanyak($dataSimpan);

        $this->reset(['logo_baru', 'favicon_baru']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi sistem berhasil diperbarui.']);
    }

    #[Title('Konfigurasi Global - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-sistem.pusat-pengaturan')
            ->layout('components.layouts.admin', ['header' => 'Pusat Pengaturan']);
    }
}