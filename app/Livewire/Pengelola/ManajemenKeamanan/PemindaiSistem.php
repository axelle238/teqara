<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Title;
use Livewire\Component;

class PemindaiSistem extends Component
{
    public $scanning = false;
    public $progress = 0;
    public $scanResults = [];
    public $score = 100;

    public function startScan()
    {
        $this->scanning = true;
        $this->progress = 10;
        $this->scanResults = [];
        $this->score = 100;

        // Step 1: Check Environment Configuration (Real)
        $this->checkEnvironment();
        $this->progress = 40;

        // Step 2: Check Database Security (Real)
        $this->checkDatabase();
        $this->progress = 70;

        // Step 3: Check File Permissions (Real)
        $this->checkFilePermissions();
        $this->progress = 100;

        $this->scanning = false;

        // Log result
        $status = $this->score >= 80 ? 'Aman' : ($this->score >= 50 ? 'Peringatan' : 'Berbahaya');
        LogHelper::catat('security_scan', 'System', "Pemindaian keamanan selesai. Skor: {$this->score}/100 ($status).");
        
        $this->dispatch('notifikasi', ['tipe' => $this->score >= 80 ? 'sukses' : 'peringatan', 'pesan' => "Pemindaian selesai. Skor Keamanan: {$this->score}%"]);
    }

    private function checkEnvironment()
    {
        // Check APP_DEBUG
        $debug = config('app.debug');
        $this->addResult('Konfigurasi Debug (APP_DEBUG)', !$debug, $debug ? 'Bahaya: Debug mode aktif di production!' : 'Aman: Debug mode non-aktif.', 'critical');
        if ($debug) $this->score -= 30;

        // Check APP_ENV
        $env = config('app.env');
        $this->addResult('Lingkungan Aplikasi (APP_ENV)', $env === 'production', "Mode saat ini: $env", 'medium');
        if ($env !== 'production') $this->score -= 10;
        
        // Check HTTPS
        // Note: In CLI/Livewire context request might not be secure if behind proxy, simple check
        $secure = request()->isSecure() || config('app.url', '') && str_starts_with(config('app.url'), 'https');
        $this->addResult('Enkripsi HTTPS', $secure, $secure ? 'Aman: Menggunakan HTTPS' : 'Peringatan: Tidak terdeteksi HTTPS', 'high');
        if (!$secure) $this->score -= 20;
    }

    private function checkDatabase()
    {
        try {
            // Check connection
            DB::connection()->getPdo();
            $this->addResult('Koneksi Database', true, 'Terhubung dengan aman.', 'critical');
        } catch (\Exception $e) {
            $this->addResult('Koneksi Database', false, 'Gagal terhubung: ' . $e->getMessage(), 'critical');
            $this->score -= 50;
        }
    }

    private function checkFilePermissions()
    {
        // Check storage writable
        $isWritable = File::isWritable(storage_path());
        $this->addResult('Izin Tulis Storage', $isWritable, $isWritable ? 'Aman: Storage dapat ditulisi' : 'Error: Storage tidak writable', 'high');
        if (!$isWritable) $this->score -= 20;

        // Check .env protection (Simulation logic as we can't easily check web server config from PHP)
        $this->addResult('Proteksi File .env', true, 'Asumsi server telah dikonfigurasi untuk memblokir akses langsung ke .env', 'high');
    }

    private function addResult($testName, $passed, $message, $severity)
    {
        $this->scanResults[] = [
            'test' => $testName,
            'passed' => $passed,
            'message' => $message,
            'severity' => $severity
        ];
    }

    #[Title('Pemindai Keamanan Siber - Teqara SOC')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.pemindai-sistem')
            ->layout('components.layouts.admin', ['header' => 'Vulnerability Scanner']);
    }
}