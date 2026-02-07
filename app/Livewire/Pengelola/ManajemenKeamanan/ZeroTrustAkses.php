<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class ZeroTrustAkses extends Component
{
    public function getSesiAktifProperty()
    {
        return collect([
            [
                'user' => 'Super Admin',
                'perangkat' => 'MacBook Pro M3',
                'lokasi' => 'Jakarta, ID',
                'ip' => '103.20.11.2',
                'skor_risiko' => 5,
                'login_pada' => now()->subMinutes(10),
                'status' => 'terverifikasi'
            ],
            [
                'user' => 'Editor Konten',
                'perangkat' => 'Windows 11 Chrome',
                'lokasi' => 'Surabaya, ID',
                'ip' => '36.11.22.1',
                'skor_risiko' => 15,
                'login_pada' => now()->subHours(1),
                'status' => 'terverifikasi'
            ],
            [
                'user' => 'Finance Manager',
                'perangkat' => 'Unknown Device',
                'lokasi' => 'Singapore, SG',
                'ip' => '128.199.22.11',
                'skor_risiko' => 85,
                'login_pada' => now()->subMinutes(5),
                'status' => 'mencurigakan'
            ]
        ]);
    }

    public function paksaKeluar($ip)
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Sesi dari IP {$ip} telah diterminasi paksa."]);
    }

    #[Title('Zero Trust Access Control - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.zero-trust-akses', [
            'sesi' => $this->sesi_aktif
        ])->layout('components.layouts.admin');
    }
}
