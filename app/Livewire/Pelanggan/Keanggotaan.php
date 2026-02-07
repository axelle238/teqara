<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;

class Keanggotaan extends Component
{
    protected function getLevels()
    {
        return [
            'Classic' => ['min' => 0, 'max' => 1000, 'color' => 'slate', 'benefits' => ['Akses Katalog Standar']],
            'Silver' => ['min' => 1001, 'max' => 5000, 'color' => 'gray', 'benefits' => ['Voucher Diskon 5%', 'Prioritas Pengiriman']],
            'Gold' => ['min' => 5001, 'max' => 20000, 'color' => 'yellow', 'benefits' => ['Voucher Diskon 10%', 'Akses Flash Sale Awal', 'Dedicated CS']],
            'Platinum' => ['min' => 20001, 'max' => 999999, 'color' => 'indigo', 'benefits' => ['Voucher Diskon 15%', 'Hadiah Ulang Tahun', 'Undangan Event Eksklusif', 'Bebas Ongkir']]
        ];
    }

    #[Title('Status Keanggotaan - Teqara Hub')]
    public function render()
    {
        $user = auth()->user();
        $level = $user->level_member ?? 'Classic';
        
        $levels = $this->getLevels();
        
        $nextLevel = match($level) {
            'Classic' => 'Silver',
            'Silver' => 'Gold',
            'Gold' => 'Platinum',
            default => null
        };

        return view('livewire.pelanggan.keanggotaan', [
            'user' => $user,
            'levels' => $levels,
            'currentLevel' => $level,
            'nextLevel' => $nextLevel
        ])->layout('components.layouts.app');
    }
}
