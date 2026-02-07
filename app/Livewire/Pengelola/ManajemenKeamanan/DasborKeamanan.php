<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\AturanFirewall;
use App\Models\InsidenKeamanan;
use App\Models\LogApi;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Dasbor SOC (Security Operations Center)
 * 
 * Pusat monitoring serangan siber dan pengelolaan pertahanan sistem.
 */
class DasborKeamanan extends Component
{
    public $statistik = [];

    public function mount()
    {
        $this->segarkanStatistik();
    }

    public function segarkanStatistik()
    {
        $this->statistik = [
            'insiden_kritis' => InsidenKeamanan::where('tingkat_keparahan', 'kritis')->count(),
            'ip_diblokir' => AturanFirewall::where('aksi', 'blokir')->count(),
            'percobaan_login_gagal' => 0, // Logic real: hitung dari log_aktivitas
            'ancaman_terdeteksi' => LogApi::count(), // Logic real: filter by pattern
        ];
    }

    #[Title('SOC Teqara - Cyber Security Center')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.dasbor-keamanan')
            ->layout('components.layouts.admin', ['header' => 'Keamanan Siber']);
    }
}