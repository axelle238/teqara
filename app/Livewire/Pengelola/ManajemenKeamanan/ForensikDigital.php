<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class ForensikDigital extends Component
{
    use WithFileUploads;

    public $fileSample;
    public $analyzing = false;
    public $analysisResult = null;

    public $evidenceLog = [
        ['id' => 'EVD-001', 'type' => 'Memory Dump', 'hash' => 'a1b2c3d4...', 'custodian' => 'Analyst A', 'timestamp' => '2023-10-26 08:00:00'],
        ['id' => 'EVD-002', 'type' => 'Disk Image', 'hash' => 'e5f6g7h8...', 'custodian' => 'Analyst B', 'timestamp' => '2023-10-25 14:30:00'],
    ];

    public function analyzeFile()
    {
        $this->validate([
            'fileSample' => 'required|max:10240', // 10MB max
        ]);

        $this->analyzing = true;

        // Simulate analysis delay
        sleep(2);

        $this->analysisResult = [
            'status' => 'malicious',
            'score' => 98,
            'family' => 'Ransomware.WannaCry.Variant',
            'indicators' => [
                'Attempts to encrypt files',
                'Connects to known C2 server',
                'Modifies registry keys'
            ]
        ];

        $this->analyzing = false;
        $this->dispatch('notifikasi', ['tipe' => 'peringatan', 'pesan' => 'Analisis selesai: Ancaman terdeteksi!']);
    }

    #[Title('Forensik Digital & Sandbox - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.forensik-digital', [
            'evidence' => $this->evidenceLog
        ])->layout('components.layouts.admin');
    }
}
