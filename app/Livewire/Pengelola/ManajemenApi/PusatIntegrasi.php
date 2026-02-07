<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use Livewire\Attributes\Title;
use Livewire\Component;

class PusatIntegrasi extends Component
{
    #[Title('Hub Integrasi Eksternal - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.pusat-integrasi')
            ->layout('components.layouts.admin', ['header' => 'Hub Integrasi']);
    }
}
