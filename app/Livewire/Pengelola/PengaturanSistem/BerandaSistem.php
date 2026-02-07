<?php

namespace App\Livewire\Pengelola\PengaturanSistem;

use App\Models\KunciApi;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

/**
 * Komponen Beranda Sistem
 * 
 * Dasbor pusat untuk memantau kesehatan teknis aplikasi dan status konfigurasi.
 */
class BerandaSistem extends Component
{
    #[Title('Dasbor Sistem - Pusat Kendali Enterprise')]
    public function render()
    {
        // Simulasi Pengecekan Sistem
        $statusDb = DB::connection()->getPdo() ? 'Terhubung' : 'Terputus';
        $ukuranDb = 0;
        try {
            $ukuranDb = DB::select('SELECT sum(data_length + index_length) / 1024 / 1024 as size FROM information_schema.TABLES WHERE table_schema = ?', [env('DB_DATABASE')])[0]->size;
        } catch (\Exception $e) { $ukuranDb = 0; }

        $statistik = [
            'total_pengaturan' => PengaturanSistem::count(),
            'kunci_api_aktif' => KunciApi::where('status', 'aktif')->count(),
            'mode_pemeliharaan' => app()->isDownForMaintenance(),
            'status_database' => $statusDb,
            'ukuran_database' => number_format($ukuranDb, 2) . ' MB',
            'versi_laravel' => app()->version(),
            'versi_php' => phpversion(),
        ];

        return view('livewire.pengelola.manajemen-sistem.beranda-sistem', [
            'statistik' => $statistik
        ])->layout('components.layouts.admin', ['header' => 'Dasbor Sistem']);
    }
}