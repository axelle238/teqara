<?php

namespace App\Livewire\Pengelola\ManajemenSistem;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Komponen Status Kesehatan Server
 * 
 * Melakukan diagnostik teknis terhadap infrastruktur aplikasi (DB, Cache, Storage).
 */
class StatusKesehatan extends Component
{
    public function getDiagnostikProperty()
    {
        // 1. Cek Database
        $dbStatus = false;
        $dbLatency = 0;
        try {
            $start = microtime(true);
            DB::select('SELECT 1');
            $dbLatency = round((microtime(true) - $start) * 1000, 2);
            $dbStatus = true;
        } catch (\Exception $e) {}

        // 2. Cek Cache
        $cacheStatus = false;
        try {
            Cache::put('health_check', 'ok', 10);
            $cacheStatus = Cache::get('health_check') === 'ok';
        } catch (\Exception $e) {}

        // 3. Storage
        $storageUsed = 0; // Simulasi atau implementasi real jika memungkinkan
        $logSize = 0;
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            $logSize = round(File::size($logPath) / 1024 / 1024, 2); // MB
        }

        return [
            'database' => ['status' => $dbStatus, 'latency' => $dbLatency . ' ms'],
            'cache' => ['status' => $cacheStatus, 'driver' => config('cache.default')],
            'storage' => ['log_size' => $logSize . ' MB'],
            'php' => phpversion(),
            'server_time' => now()->format('Y-m-d H:i:s'),
        ];
    }

    public function bersihkanCache()
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Cache sistem berhasil dibersihkan.']);
    }

    #[Title('Diagnostik Kesehatan Server - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-sistem.status-kesehatan')
            ->layout('components.layouts.admin', ['header' => 'Kesehatan Server']);
    }
}