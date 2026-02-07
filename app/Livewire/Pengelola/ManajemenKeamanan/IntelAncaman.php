<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class IntelAncaman extends Component
{
    public $ancamanDunia = [];
    public $blokirNegara = [];

    public function mount()
    {
        // Simulasi Data Intelijen (Di production bisa integrasi API pihak ke-3)
        $this->ancamanDunia = [
            ['negara' => 'CN', 'nama' => 'China', 'serangan' => 1450, 'level' => 'tinggi'],
            ['negara' => 'RU', 'nama' => 'Russia', 'serangan' => 980, 'level' => 'tinggi'],
            ['negara' => 'US', 'nama' => 'United States', 'serangan' => 450, 'level' => 'sedang'],
            ['negara' => 'BR', 'nama' => 'Brazil', 'serangan' => 320, 'level' => 'sedang'],
            ['negara' => 'IN', 'nama' => 'India', 'serangan' => 210, 'level' => 'rendah'],
        ];

        $this->blokirNegara = [
            'KP' => 'Korea Utara',
            'IR' => 'Iran',
        ];
    }

    public function blokirNegara($kode, $nama)
    {
        $this->blokirNegara[$kode] = $nama;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Akses dari negara {$nama} telah diblokir di tingkat firewall."]);
    }

    public function lepasBlokir($kode)
    {
        unset($this->blokirNegara[$kode]);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => "Blokir negara dicabut."]);
    }

    #[Title('Intelijen Ancaman Global - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.intel-ancaman')
            ->layout('components.layouts.admin');
    }
}
