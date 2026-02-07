<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class AnalisisPerilakuUser extends Component
{
    public function getAnomaliesProperty()
    {
        return collect([
            [
                'user' => 'Finance Manager',
                'risk_score' => 88,
                'anomaly_type' => 'Data Exfiltration',
                'description' => 'Mendownload 5GB data pelanggan pada jam 02:00 pagi (biasanya tidak aktif).',
                'status' => 'investigating'
            ],
            [
                'user' => 'IT Admin',
                'risk_score' => 65,
                'anomaly_type' => 'Impossible Travel',
                'description' => 'Login dari Jakarta dan London dalam selisih waktu 15 menit.',
                'status' => 'verified'
            ],
            [
                'user' => 'Sales Lead',
                'risk_score' => 45,
                'anomaly_type' => 'Privilege Escalation',
                'description' => 'Mencoba mengakses folder /etc/shadow 3 kali.',
                'status' => 'closed'
            ]
        ]);
    }

    public function freezeAccount($user)
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Akun {$user} telah dibekukan sementara untuk investigasi."]);
    }

    #[Title('UBA - User Behavior Analytics - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.analisis-perilaku-user', [
            'anomalies' => $this->anomalies
        ])->layout('components.layouts.admin');
    }
}
