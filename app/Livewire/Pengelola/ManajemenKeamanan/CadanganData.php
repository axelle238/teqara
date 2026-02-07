<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;

class CadanganData extends Component
{
    public $lastBackup;
    public $backupSize;

    public function mount()
    {
        $this->lastBackup = now()->subDays(2); // Simulated
        $this->backupSize = '450 MB';
    }

    public function buatCadangan()
    {
        // Logic to run `php artisan backup:run` via console or job
        // Simulation:
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Proses backup dimulai di latar belakang...']);
        
        // Simulate completion after delay
        $this->lastBackup = now();
    }

    public function unduh($type = 'db')
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Mengunduh arsip ' . strtoupper($type) . '...']);
    }

    #[Title('Cadangan & Pemulihan Data - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.cadangan-data')
            ->layout('components.layouts.admin', ['header' => 'Disaster Recovery']);
    }
}
