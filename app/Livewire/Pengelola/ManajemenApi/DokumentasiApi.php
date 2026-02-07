<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use Livewire\Attributes\Title;
use Livewire\Component;

class DokumentasiApi extends Component
{
    public $tabAktif = 'pengenalan';

    public function setTab($tab)
    {
        $this->tabAktif = $tab;
    }

    #[Title('Dokumentasi Developer API - Teqara Hub')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.dokumentasi-api')
            ->layout('components.layouts.admin', ['header' => 'Pusat Developer']);
    }
}
