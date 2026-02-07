<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;

class DeteksiEndpoint extends Component
{
    public $endpoints = [
        ['id' => 'SRV-WEB-01', 'os' => 'Ubuntu 22.04', 'ip' => '10.0.0.5', 'status' => 'online', 'health' => '98%', 'last_seen' => 'Just now'],
        ['id' => 'SRV-DB-01', 'os' => 'Ubuntu 22.04', 'ip' => '10.0.0.6', 'status' => 'online', 'health' => '99%', 'last_seen' => 'Just now'],
        ['id' => 'WORKSTATION-05', 'os' => 'Windows 11', 'ip' => '192.168.1.105', 'status' => 'warning', 'health' => '75%', 'last_seen' => '5 mins ago'],
    ];

    public $processes = [
        ['pid' => 1234, 'name' => 'nginx', 'user' => 'www-data', 'cpu' => '5.2%', 'mem' => '120MB', 'status' => 'normal'],
        ['pid' => 5678, 'name' => 'mysqld', 'user' => 'mysql', 'cpu' => '12.5%', 'mem' => '2GB', 'status' => 'normal'],
        ['pid' => 9999, 'name' => 'unknown.exe', 'user' => 'root', 'cpu' => '0.1%', 'mem' => '5MB', 'status' => 'suspicious'],
    ];

    public function isolateHost($id)
    {
        $this->endpoints = array_map(function ($ep) use ($id) {
            if ($ep['id'] === $id) {
                $ep['status'] = 'isolated';
            }
            return $ep;
        }, $this->endpoints);

        $this->dispatch('notifikasi', ['tipe' => 'peringatan', 'pesan' => "Endpoint {$id} telah diisolasi dari jaringan."]);
    }

    public function killProcess($pid)
    {
        $this->processes = array_filter($this->processes, fn($p) => $p['pid'] != $pid);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Proses PID {$pid} berhasil dihentikan."]);
    }

    #[Title('EDR - Deteksi & Respon Endpoint - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.deteksi-endpoint', [
            'endpoints' => $this->endpoints,
            'processes' => $this->processes
        ])->layout('components.layouts.admin');
    }
}
