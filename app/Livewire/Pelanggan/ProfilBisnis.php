<?php

namespace App\Livewire\Pelanggan;

use App\Models\ProfilBisnis as ModelProfilBisnis;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProfilBisnis extends Component
{
    public $nama_perusahaan;
    public $npwp;
    public $alamat_perusahaan;
    public $email_bisnis;
    public $telepon_bisnis;

    public function mount()
    {
        $profil = ModelProfilBisnis::where('pengguna_id', auth()->id())->first();
        if ($profil) {
            $this->nama_perusahaan = $profil->nama_perusahaan;
            $this->npwp = $profil->npwp;
            $this->alamat_perusahaan = $profil->alamat_perusahaan;
            $this->email_bisnis = $profil->email_bisnis;
            $this->telepon_bisnis = $profil->telepon_bisnis;
        }
    }

    public function simpan()
    {
        $this->validate([
            'nama_perusahaan' => 'required|string|min:3',
            'npwp' => 'nullable|string|min:15',
            'email_bisnis' => 'nullable|email',
        ]);

        ModelProfilBisnis::updateOrCreate(
            ['pengguna_id' => auth()->id()],
            [
                'nama_perusahaan' => $this->nama_perusahaan,
                'npwp' => $this->npwp,
                'alamat_perusahaan' => $this->alamat_perusahaan,
                'email_bisnis' => $this->email_bisnis,
                'telepon_bisnis' => $this->telepon_bisnis,
            ]
        );

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Profil bisnis berhasil diperbarui.']);
    }

    #[Title('Identitas Bisnis & Pajak - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.profil-bisnis')
            ->layout('components.layouts.app');
    }
}
