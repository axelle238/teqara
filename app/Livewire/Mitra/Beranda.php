<?php

namespace App\Livewire\Mitra;

use Livewire\Attributes\Title;
use Livewire\Component;

class Beranda extends Component
{
    #[Title('Dashboard Mitra - Teqara B2B')]
    public function render()
    {
        return view('livewire.mitra.beranda')
            ->layout('components.layouts.mitra');
    }
}
