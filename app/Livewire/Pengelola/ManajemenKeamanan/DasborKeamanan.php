<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\AturanFirewall;
use App\Models\InsidenKeamanan;
use App\Models\LogAktivitas;
use App\Models\LogApi; // Fixed import
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Dasbor SOC (Security Operations Center)
 * 
 * Pusat monitoring serangan siber dan pengelolaan pertahanan sistem.
 * Mendukung pemantauan Real-time (Polling) untuk peta serangan.
 */
class DasborKeamanan extends Component
{
    public $statistik = [];
    public $seranganMap = []; // Data koordinat serangan palsu untuk visualisasi
    public $defconLevel = 5; // 5 (Aman) - 1 (Kritis)
    public $terminalLogs = [];

    public function mount()
    {
        $this->segarkanStatistik();
    }

    /**
     * Memperbarui data statistik dan simulasi serangan secara real-time.
     * Dipanggil via wire:poll.
     */
    public function segarkanStatistik()
    {
        // 1. Statistik Nyata dari Database
        $insidenKritis = InsidenKeamanan::where('tingkat_keparahan', 'kritis')->count();
        $ipDiblokir = AturanFirewall::where('aksi', 'blokir')->count();
        
        // 2. Simulasi / Hitungan Real-time
        $this->statistik = [
            'insiden_kritis' => $insidenKritis,
            'ip_diblokir' => $ipDiblokir,
            'percobaan_login_gagal' => LogAktivitas::where('aksi', 'login_gagal')->where('waktu', '>=', now()->subDay())->count(),
            'ancaman_terdeteksi' => LogApi::count() + rand(10, 50), // Simulasi tambahan traffic
        ];

        // 3. Tentukan DEFCON Level
        if ($insidenKritis > 10) $this->defconLevel = 1;
        elseif ($insidenKritis > 5) $this->defconLevel = 2;
        elseif ($insidenKritis > 0) $this->defconLevel = 3;
        else $this->defconLevel = 5;

        // 4. Generate Simulasi Serangan untuk Peta (Visual Effect)
        $this->seranganMap = [];
        for ($i = 0; $i < rand(3, 8); $i++) {
            $this->seranganMap[] = [
                'top' => rand(20, 80) . '%',
                'left' => rand(10, 90) . '%',
                'type' => collect(['DDoS', 'SQLi', 'XSS', 'Brute Force'])->random()
            ];
        }

        // 5. Generate Fake Terminal Logs
        $this->terminalLogs = [];
        $types = ['INFO', 'WARN', 'BLOCK', 'CRITICAL'];
        $msgs = [
            'Scanning ports 80, 443...',
            'Packet dropped from 192.168.1.X',
            'Signature match: Trojan.Win32',
            'Outbound traffic spike detected',
            'Integrity check passed: /etc/passwd'
        ];
        
        for($i=0; $i<6; $i++) {
            $this->terminalLogs[] = [
                'time' => now()->subSeconds($i * rand(2, 10))->format('H:i:s'),
                'type' => $types[array_rand($types)],
                'msg' => $msgs[array_rand($msgs)]
            ];
        }
    }

    #[Title('SOC Teqara - Cyber Security Center')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.dasbor-keamanan')
            ->layout('components.layouts.admin', ['header' => 'Keamanan Siber']);
    }
}
