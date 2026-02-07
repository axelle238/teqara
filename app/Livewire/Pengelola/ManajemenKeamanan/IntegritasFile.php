<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Services\LayananKeamanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class IntegritasFile extends Component
{
    public $scanStatus = 'idle'; 
    public $hasilScan = [];

    public function mulaiScan(LayananKeamanan $keamanan)
    {
        $this->scanStatus = 'scanning';
        
        // Real scanning logic via service
        $this->hasilScan = $keamanan->periksaIntegritasSistem();
        
        sleep(1); // Simulate work for UI effect
        $this->scanStatus = 'selesai';
        $this->dispatch('notifikasi', tipe: 'sukses', pesan: "Verifikasi integritas file inti selesai.");
    }

    #[Title('Integritas File Sistem - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.integritas-file')
            ->layout('components.layouts.admin');
    }
}
