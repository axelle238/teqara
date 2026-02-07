<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class HoneypotLog extends Component
{
    use WithPagination;

    public $filterTipe = '';

    public function getLogsProperty()
    {
        // Simulasi Log Honeypot
        return collect([
            [
                'ip' => '192.168.1.105',
                'lokasi' => 'Unknown',
                'target' => '/admin/wp-login.php',
                'metode' => 'GET',
                'user_agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
                'waktu' => now()->subMinutes(5)
            ],
            [
                'ip' => '45.33.22.11',
                'lokasi' => 'US',
                'target' => '/phpmyadmin',
                'metode' => 'POST',
                'user_agent' => 'Python-urllib/3.8',
                'waktu' => now()->subMinutes(12)
            ],
            [
                'ip' => '103.22.1.5',
                'lokasi' => 'ID',
                'target' => '/env',
                'metode' => 'GET',
                'user_agent' => 'curl/7.68.0',
                'waktu' => now()->subHours(1)
            ],
            [
                'ip' => '88.99.11.22',
                'lokasi' => 'DE',
                'target' => '/api/v1/users',
                'metode' => 'GET',
                'user_agent' => 'PostmanRuntime/7.26.8',
                'waktu' => now()->subHours(3)
            ],
        ]);
    }

    public function blokirPermanen($ip)
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "IP {$ip} telah ditambahkan ke daftar hitam permanen Firewall."]);
    }

    #[Title('Jebakan Honeypot - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.honeypot-log', [
            'logs' => $this->logs
        ])->layout('components.layouts.admin');
    }
}
