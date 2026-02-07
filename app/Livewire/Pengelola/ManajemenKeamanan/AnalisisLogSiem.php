<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class AnalisisLogSiem extends Component
{
    public $filterKategori = '';
    public $search = '';

    public function getLogsProperty()
    {
        return collect([
            [
                'waktu' => now()->subSeconds(45),
                'sumber' => 'WAF-01',
                'event' => 'SQL Injection Attempt',
                'detail' => 'payload: UNION SELECT 1,2,3--',
                'level' => 'kritis',
                'ip' => '103.20.11.2'
            ],
            [
                'waktu' => now()->subMinutes(2),
                'sumber' => 'AUTH-SVC',
                'event' => 'Brute Force Login',
                'detail' => 'user: admin, attempts: 50/min',
                'level' => 'tinggi',
                'ip' => '45.11.22.33'
            ],
            [
                'waktu' => now()->subMinutes(5),
                'sumber' => 'APP-CORE',
                'event' => 'Invalid CSRF Token',
                'detail' => 'route: /checkout/process',
                'level' => 'sedang',
                'ip' => '192.168.1.50'
            ],
            [
                'waktu' => now()->subMinutes(10),
                'sumber' => 'SYS-MON',
                'event' => 'High CPU Usage',
                'detail' => 'cpu: 95%, proc: php-fpm',
                'level' => 'rendah',
                'ip' => 'localhost'
            ],
        ]);
    }

    #[Title('SIEM - Analisis Log Terpusat - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.analisis-log-siem', [
            'logs' => $this->logs
        ])->layout('components.layouts.admin');
    }
}
