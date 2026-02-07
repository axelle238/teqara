<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class IntegritasFile extends Component
{
    public $scanStatus = 'idle'; // idle, scanning, selesai
    public $progress = 0;
    public $fileBerubah = [];

    public function mulaiScan()
    {
        $this->scanStatus = 'scanning';
        $this->progress = 0;
        $this->dispatch('mulai-scan-integritas');
    }

    public function updateProgress()
    {
        if ($this->progress < 100) {
            $this->progress += rand(10, 25);
            if ($this->progress >= 100) {
                $this->progress = 100;
                $this->selesaiScan();
            }
        }
    }

    public function selesaiScan()
    {
        $this->scanStatus = 'selesai';
        
        // Simulasi hasil scan
        $this->fileBerubah = [
            [
                'path' => 'public/index.php',
                'status' => 'aman',
                'hash' => 'd41d8cd98f00b204e9800998ecf8427e',
                'waktu' => now()->subMinutes(2)
            ],
            [
                'path' => '.env',
                'status' => 'peringatan',
                'hash' => 'a8f5f167f44f4964e6c998dee827110c',
                'waktu' => now()->subHours(5)
            ],
            [
                'path' => 'app/Http/Kernel.php',
                'status' => 'aman',
                'hash' => '900150983cd24fb0d6963f7d28e17f72',
                'waktu' => now()->subDays(1)
            ]
        ];

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Pemindaian integritas file selesai."]);
    }

    #[Title('Integritas File Sistem - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.integritas-file')
            ->layout('components.layouts.admin');
    }
}
