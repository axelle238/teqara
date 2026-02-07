<?php

namespace App\Livewire\Pelanggan\Poin;

use App\Models\RiwayatPoin;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;

class AbsensiHarian extends Component
{
    public function getHariIniProperty()
    {
        return now();
    }

    public function getSudahAbsenProperty()
    {
        return RiwayatPoin::where('pengguna_id', auth()->id())
            ->where('sumber', 'absensi')
            ->whereDate('dibuat_pada', today())
            ->exists();
    }

    public function getStreakProperty()
    {
        // Simulasi streak. Logic aslinya butuh query rekursif atau kolom khusus di user table.
        return 5; 
    }

    public function klaimPoin()
    {
        if ($this->sudahAbsen) {
            return;
        }

        $poinDapat = 100 + ($this->streak * 10); // Bonus streak

        RiwayatPoin::create([
            'pengguna_id' => auth()->id(),
            'jumlah' => $poinDapat,
            'sumber' => 'absensi',
            'keterangan' => 'Check-in Harian (Streak ' . $this->streak . ' Hari)'
        ]);

        auth()->user()->increment('poin_loyalitas', $poinDapat);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Selamat! Anda mendapatkan {$poinDapat} Poin."]);
    }

    #[Title('Check-in Harian - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.poin.absensi-harian')
            ->layout('components.layouts.app');
    }
}
