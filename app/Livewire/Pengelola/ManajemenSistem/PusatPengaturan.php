<?php

namespace App\Livewire\Pengelola\ManajemenSistem;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class PusatPengaturan extends Component
{
    use WithFileUploads;

    public $activeTab = 'umum';
    
    // Umum
    public $nama_situs;
    public $deskripsi_situs;
    public $email_dukungan;
    public $telepon_dukungan;
    public $alamat_fisik;
    
    // Sosial Media
    public $sosial_facebook;
    public $sosial_instagram;
    public $sosial_twitter;
    
    // Bisnis
    public $pajak_persen;
    public $mata_uang = 'IDR';

    // SEO
    public $seo_keywords;
    public $seo_description;
    
    // Logo (Simulated for now, would need storage link)
    public $logo_baru;

    public function mount()
    {
        // Load existing settings from database or fallback to config
        $settings = PengaturanSistem::pluck('nilai', 'kunci');

        $this->nama_situs = $settings['nama_situs'] ?? config('app.name', 'Teqara Enterprise');
        $this->deskripsi_situs = $settings['deskripsi_situs'] ?? 'Platform e-commerce B2B/B2C terdepan.';
        $this->email_dukungan = $settings['email_dukungan'] ?? 'support@teqara.com';
        $this->telepon_dukungan = $settings['telepon_dukungan'] ?? '+62 812 3456 7890';
        $this->alamat_fisik = $settings['alamat_fisik'] ?? 'Jakarta, Indonesia';
        
        $this->sosial_facebook = $settings['sosial_facebook'] ?? '#';
        $this->sosial_instagram = $settings['sosial_instagram'] ?? '#';
        $this->sosial_twitter = $settings['sosial_twitter'] ?? '#';

        $this->pajak_persen = $settings['pajak_persen'] ?? 11;
        $this->mata_uang = $settings['mata_uang'] ?? 'IDR';

        $this->seo_keywords = $settings['seo_keywords'] ?? 'ecommerce, teqara, belanja online';
        $this->seo_description = $settings['seo_description'] ?? $this->deskripsi_situs;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function simpan()
    {
        $this->validate([
            'nama_situs' => 'required|string|max:255',
            'email_dukungan' => 'required|email',
            'pajak_persen' => 'required|numeric|min:0|max:100',
        ]);

        // Save to database
        $settings = [
            'nama_situs' => $this->nama_situs,
            'deskripsi_situs' => $this->deskripsi_situs,
            'email_dukungan' => $this->email_dukungan,
            'telepon_dukungan' => $this->telepon_dukungan,
            'alamat_fisik' => $this->alamat_fisik,
            'sosial_facebook' => $this->sosial_facebook,
            'sosial_instagram' => $this->sosial_instagram,
            'sosial_twitter' => $this->sosial_twitter,
            'pajak_persen' => $this->pajak_persen,
            'mata_uang' => $this->mata_uang,
            'seo_keywords' => $this->seo_keywords,
            'seo_description' => $this->seo_description,
        ];

        foreach ($settings as $key => $value) {
            PengaturanSistem::updateOrCreate(
                ['kunci' => $key],
                ['nilai' => $value, 'tipe' => is_numeric($value) ? 'number' : 'text']
            );
        }
        
        LogHelper::catat('update_konfigurasi', 'Global', "Pengaturan sistem diperbarui oleh " . auth()->user()->nama);
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi sistem berhasil disimpan ke database.']);
    }

    #[Title('Pusat Kontrol Sistem - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-sistem.pusat-pengaturan')
            ->layout('components.layouts.admin', ['header' => 'System Control Center']);
    }
}
