<?php

namespace App\Livewire\Pelanggan;

use App\Models\Voucher;
use Livewire\Attributes\Title;
use Livewire\Component;

class VoucherSaya extends Component
{
    public function getVoucherTersediaProperty()
    {
        // Simulasi voucher berdasarkan level (karena belum ada tabel user_voucher)
        $level = auth()->user()->level_member ?? 'Classic';
        
        $query = Voucher::where('status', 'aktif')
            ->where('berlaku_sampai', '>=', now());

        // Enterprise Logic: Level-based filtering
        if ($level === 'Classic') {
            $query->where('kode', 'LIKE', '%NEW%');
        } elseif ($level === 'Silver') {
            $query->where('min_belanja', '<=', 500000);
        }
        // Gold/Platinum get all

        return $query->get();
    }

    public function salinKode($kode)
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Kode {$kode} disalin ke clipboard."]);
    }

    #[Title('Dompet Voucher - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.voucher-saya')
            ->layout('components.layouts.app');
    }
}
