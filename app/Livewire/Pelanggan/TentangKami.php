<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;

class TentangKami extends Component
{
    #[Title('Tentang Kami - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.tentang-kami')
            ->layout('components.layouts.app');
    }
}
