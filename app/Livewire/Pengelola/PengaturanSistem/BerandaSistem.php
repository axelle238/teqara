<?php

namespace App\Livewire\Pengelola\PengaturanSistem;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class BerandaSistem
 * Tujuan: Pusat konfigurasi global aplikasi (Identitas Toko, SEO, Kontak).
 */
class BerandaSistem extends Component
{
    use WithFileUploads;

    public $nama_toko;
    public $deskripsi_toko;
    public $email_kontak;
    public $nomor_telepon;
    public $alamat_toko;
    public $logo;
    public $logo_lama;

    public function mount()
    {
        $settings = PengaturanSistem::pluck('nilai', 'kunci')->toArray();
        
        $this->nama_toko = $settings['nama_toko'] ?? 'Teqara';
        $this->deskripsi_toko = $settings['deskripsi_toko'] ?? '';
        $this->email_kontak = $settings['email_kontak'] ?? '';
        $this->nomor_telepon = $settings['nomor_telepon'] ?? '';
        $this->alamat_toko = $settings['alamat_toko'] ?? '';
        $this->logo_lama = $settings['logo_toko'] ?? null;
    }

    public function simpan()
    {
        $this->validate([
            'nama_toko' => 'required|min:3',
            'email_kontak' => 'required|email',
        ]);

        $data = [
            'nama_toko' => $this->nama_toko,
            'deskripsi_toko' => $this->deskripsi_toko,
            'email_kontak' => $this->email_kontak,
            'nomor_telepon' => $this->nomor_telepon,
            'alamat_toko' => $this->alamat_toko,
        ];

        if ($this->logo) {
            $path = $this->logo->store('sistem', 'public');
            $data['logo_toko'] = '/storage/' . $path;
        }

        foreach ($data as $key => $value) {
            PengaturanSistem::updateOrCreate(['kunci' => $key], ['nilai' => $value]);
        }

        LogHelper::catat('update_pengaturan', 'Sistem', 'Admin memperbarui konfigurasi toko.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pengaturan sistem berhasil disimpan.']);
    }

    #[Title('Konfigurasi Global - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.pengaturan-sistem.beranda-sistem')
            ->layout('components.layouts.admin', ['header' => 'Pengaturan Sistem']);
    }
}
