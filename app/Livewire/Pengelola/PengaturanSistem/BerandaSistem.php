<?php

namespace App\Livewire\Pengelola\PengaturanSistem;

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
    // Identitas
    public $nama_toko;

    public $email_kontak;

    public $nomor_wa;

    public $alamat_toko;

    // SEO & Metadata
    public $meta_deskripsi;

    public $kata_kunci;

    // Operasional
    public $jam_buka;

    public $jam_tutup;

    public $mata_uang = 'IDR';

    // Integrasi API (Simulasi Masking)
    public $api_payment_gateway;

    public $api_kurir;

    public function mount()
    {
        $settings = PengaturanSistem::pluck('nilai', 'kunci');

        $this->nama_toko = $settings['nama_toko'] ?? 'Teqara Enterprise';
        $this->email_kontak = $settings['email_kontak'] ?? '';
        $this->nomor_wa = $settings['nomor_wa'] ?? '';
        $this->alamat_toko = $settings['alamat_toko'] ?? '';

        $this->meta_deskripsi = $settings['meta_deskripsi'] ?? 'Pusat belanja komputer dan gadget terlengkap.';
        $this->kata_kunci = $settings['kata_kunci'] ?? 'komputer, gadget, laptop, teqara';

        $this->jam_buka = $settings['jam_buka'] ?? '09:00';
        $this->jam_tutup = $settings['jam_tutup'] ?? '21:00';

        $this->api_payment_gateway = $settings['api_payment_gateway'] ?? '';
        $this->api_kurir = $settings['api_kurir'] ?? '';
    }

    public function simpan()
    {
        $this->validate([
            'nama_toko' => 'required|string|max:255',
            'email_kontak' => 'required|email',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
        ]);

        $data = [
            'nama_toko' => $this->nama_toko,
            'email_kontak' => $this->email_kontak,
            'nomor_wa' => $this->nomor_wa,
            'alamat_toko' => $this->alamat_toko,
            'meta_deskripsi' => $this->meta_deskripsi,
            'kata_kunci' => $this->kata_kunci,
            'jam_buka' => $this->jam_buka,
            'jam_tutup' => $this->jam_tutup,
            'api_payment_gateway' => $this->api_payment_gateway,
            'api_kurir' => $this->api_kurir,
        ];

        foreach ($data as $key => $value) {
            PengaturanSistem::updateOrCreate(
                ['kunci' => $key],
                ['nilai' => $value, 'tipe' => 'text']
            );
        }

        LogHelper::catat('perbarui_pengaturan', 'Sistem', 'Admin memperbarui konfigurasi infrastruktur global.', $data);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi sistem berhasil diperbarui.']);
    }

    #[Title('Pengaturan Sistem - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.pengaturan-sistem.beranda-sistem')
            ->layout('components.layouts.admin');
    }
}
