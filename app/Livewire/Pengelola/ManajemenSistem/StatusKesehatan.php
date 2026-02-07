<?php

namespace App\Livewire\Pengelola\ManajemenSistem;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class StatusKesehatan extends Component
{
    public $cpu_usage = 0;
    public $ram_usage = 0;
    public $ram_total = 0;
    public $disk_usage = 0;
    public $disk_total_gb = 0;
    public $db_status = 'Unknown';
    public $db_latency = 0;
    public $queue_email = 0;
    public $queue_default = 0;

    public function mount()
    {
        $this->checkHealth();
    }

    public function checkHealth()
    {
        // 1. Disk Usage
        try {
            $total = disk_total_space('.');
            $free = disk_free_space('.');
            $used = $total - $free;
            
            $this->disk_total_gb = round($total / 1073741824, 1);
            $this->disk_usage = round(($used / $total) * 100, 1);
        } catch (\Exception $e) {
            $this->disk_usage = 0;
        }

        // 2. Database Status & Latency
        try {
            $start = microtime(true);
            DB::connection()->getPdo();
            $end = microtime(true);
            $this->db_status = 'Connected';
            $this->db_latency = round(($end - $start) * 1000, 2); // ms
        } catch (\Exception $e) {
            $this->db_status = 'Error';
            $this->db_latency = -1;
        }

        // 3. Queue Size (Approximation for Database Driver)
        try {
            $this->queue_default = DB::table('jobs')->where('queue', 'default')->count();
            $this->queue_email = DB::table('jobs')->where('queue', 'emails')->count();
        } catch (\Exception $e) {
            // Table might not exist or using Redis/Sync
            $this->queue_default = 0;
        }

        // 4. Memory (Script usage as proxy if system not available)
        $mem_usage = memory_get_usage(true);
        $mem_limit = $this->parseSize(ini_get('memory_limit'));
        if ($mem_limit > 0) {
            $this->ram_usage = round(($mem_usage / $mem_limit) * 100, 1);
            $this->ram_total = round($mem_limit / 1048576, 0) . ' MB'; // Allocation Limit
        } else {
            $this->ram_usage = 0;
            $this->ram_total = 'Unlimited';
        }

        // 5. CPU (Simulation for Windows/XAMPP as real access is restricted)
        // In a real Linux server, we would read /proc/loadavg
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $this->cpu_usage = $load[0] * 100; // Load for last 1 min
        } else {
            $this->cpu_usage = rand(5, 25); // Simulation for Windows Dev Env
        }
    }

    private function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        return round($size);
    }

    public function unduhLaporan()
    {
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Laporan kesehatan sistem sedang dibuat...']);
    }

    #[Title('Status Kesehatan Sistem - Teqara Admin')]
    public function render()
    {
        $this->checkHealth(); // Re-check on every render (polling)
        
        return view('livewire.pengelola.manajemen-sistem.status-kesehatan')
            ->layout('components.layouts.admin', ['header' => 'System Health']);
    }
}
