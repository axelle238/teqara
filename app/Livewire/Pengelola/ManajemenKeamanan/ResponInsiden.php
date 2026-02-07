<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class ResponInsiden extends Component
{
    public function getKasusProperty()
    {
        return collect([
            [
                'id' => 'INC-2023-001',
                'judul' => 'Suspicious Outbound Traffic',
                'status' => 'investigasi',
                'severitas' => 'tinggi',
                'analis' => 'SOC Team A',
                'dibuat' => now()->subHours(3)
            ],
            [
                'id' => 'INC-2023-002',
                'judul' => 'Multiple Failed Logins',
                'status' => 'selesai',
                'severitas' => 'sedang',
                'analis' => 'Auto-Bot',
                'dibuat' => now()->subDays(1)
            ]
        ]);
    }

    public function jalankanPlaybook($id, $playbook)
    {
        // Simulasi eksekusi playbook
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Playbook '{$playbook}' dijalankan untuk kasus {$id}."]);
    }

    #[Title('IRP - Respon Insiden Otomatis - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.respon-insiden', [
            'kasus' => $this->kasus
        ])->layout('components.layouts.admin');
    }
}
