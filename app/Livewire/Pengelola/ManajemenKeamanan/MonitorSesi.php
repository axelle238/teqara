<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class MonitorSesi extends Component
{
    public function hapusSesi($id)
    {
        DB::table('sesi')->where('id', $id)->delete();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Sesi pengguna berhasil dihentikan paksa.']);
    }

    public function hapusSemua()
    {
        DB::table('sesi')->truncate();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Semua sesi aktif telah dibersihkan.']);
    }

    #[Title('Monitor Sesi Aktif - Teqara Security')]
    public function render()
    {
        // Join dengan tabel pengguna (id) ke sesi (pengguna_id)
        $sessions = DB::table('sesi')
            ->leftJoin('pengguna', 'sesi.pengguna_id', '=', 'pengguna.id')
            ->select('sesi.*', 'pengguna.nama', 'pengguna.email', 'pengguna.peran', 'pengguna.foto_profil')
            ->orderByDesc('aktivitas_terakhir')
            ->get()
            ->map(function ($s) {
                $s->aktivitas_terakhir = \Carbon\Carbon::createFromTimestamp($s->aktivitas_terakhir);
                
                // Parse User Agent sederhana
                $agent = $s->agen_pengguna ?? '-';
                $s->platform = str_contains($agent, 'Windows') ? 'Windows' : (str_contains($agent, 'Mac') ? 'MacOS' : (str_contains($agent, 'Linux') ? 'Linux' : 'Unknown'));
                $s->browser = str_contains($agent, 'Chrome') ? 'Chrome' : (str_contains($agent, 'Firefox') ? 'Firefox' : 'Browser Lain');
                
                return $s;
            });

        return view('livewire.pengelola.manajemen-keamanan.monitor-sesi', [
            'sessions' => $sessions
        ])->layout('components.layouts.admin', ['header' => 'Session Monitor']);
    }
}
