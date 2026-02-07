<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;

class Referral extends Component
{
    public function getUserProperty()
    {
        return auth()->user();
    }

    public function getKodeReferralProperty()
    {
        // Simple generation based on ID if not exists in DB column
        return 'TEQARA-' . str_pad($this->user->id, 6, '0', STR_PAD_LEFT);
    }

    public function getStatistikProperty()
    {
        // Mockup statistics. In real app, query Pengguna where referral_by = this user
        return [
            'total_undangan' => 12,
            'undangan_sukses' => 5, // Registered & Purchased
            'total_komisi' => 250000, // Points or Cash
        ];
    }

    public function getRiwayatUndanganProperty()
    {
        // Mockup list
        return collect([
            ['nama' => 'Budi Santoso', 'status' => 'Aktif', 'tanggal' => now()->subDays(2), 'komisi' => 50000],
            ['nama' => 'Siti Aminah', 'status' => 'Menunggu Pembelian', 'tanggal' => now()->subDays(5), 'komisi' => 0],
            ['nama' => 'Andi Pratama', 'status' => 'Aktif', 'tanggal' => now()->subWeeks(1), 'komisi' => 50000],
        ]);
    }

    public function salinLink()
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Link referral berhasil disalin!']);
    }

    #[Title('Program Referral - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.referral')
            ->layout('components.layouts.app');
    }
}
