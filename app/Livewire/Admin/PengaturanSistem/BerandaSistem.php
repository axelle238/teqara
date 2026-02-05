<?php

namespace App\Livewire\Admin\PengaturanSistem;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaSistem
 * Tujuan: Dashboard pilar Pengaturan Sistem Terpusat.
 */
class BerandaSistem extends Component
{
    public $nama_toko;

    public $email_kontak;

    public $nomor_wa;

    public $alamat_toko;

    public function mount()
    {
        $settings = PengaturanSistem::pluck('nilai', 'kunci');

        $this->nama_toko = $settings['nama_toko'] ?? 'Teqara Enterprise';
        $this->email_kontak = $settings['email_kontak'] ?? '';
        $this->nomor_wa = $settings['nomor_wa'] ?? '';
        $this->alamat_toko = $settings['alamat_toko'] ?? '';
    }

    public function simpan()
    {
        $this->validate([
            'nama_toko' => 'required|string|max:255',
            'email_kontak' => 'required|email',
            'nomor_wa' => 'required|string',
        ]);

        $data = [
            'nama_toko' => $this->nama_toko,
            'email_kontak' => $this->email_kontak,
            'nomor_wa' => $this->nomor_wa,
            'alamat_toko' => $this->alamat_toko,
        ];

        foreach ($data as $key => $value) {
            PengaturanSistem::updateOrCreate(
                ['kunci' => $key],
                ['nilai' => $value, 'tipe' => 'text']
            );
        }

        LogHelper::catat('perbarui_pengaturan', 'Sistem', 'Admin memperbarui konfigurasi toko utama.', $data);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pengaturan sistem berhasil diperbarui.']);
    }

    #[Title('Pengaturan Sistem - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.pengaturan-sistem.beranda-sistem')
            ->layout('components.layouts.admin');
    }
}
