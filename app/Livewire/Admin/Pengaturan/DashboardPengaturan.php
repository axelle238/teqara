<?php

namespace App\Livewire\Admin\Pengaturan;

use App\Helpers\LogHelper;
use App\Models\Pengaturan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardPengaturan extends Component
{
    public $nama_toko;

    public $email_kontak;

    public $nomor_wa;

    public $alamat_toko;

    public function mount()
    {
        $settings = Pengaturan::pluck('nilai', 'kunci');

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
            Pengaturan::updateOrCreate(
                ['kunci' => $key],
                ['nilai' => $value, 'tipe' => 'text']
            );
        }

        LogHelper::catat('update_pengaturan', 'Sistem', 'Admin memperbarui konfigurasi toko utama.', $data);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pengaturan sistem berhasil diperbarui.']);
    }

    #[Title('Pengaturan Sistem - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.pengaturan.dashboard-pengaturan')
            ->layout('components.layouts.admin');
    }
}
