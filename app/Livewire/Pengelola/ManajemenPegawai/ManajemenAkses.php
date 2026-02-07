<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use Livewire\Component;
use Livewire\Attributes\Title;

class ManajemenAkses extends Component
{
    #[Title('Manajemen Hak Akses & Peran - Teqara Enterprise')]
    public function render()
    {
        return view('components.pengelola.manajemen-pegawai.⚡manajemen-akses')
            ->layout('components.layouts.admin', ['header' => 'Manajemen Hak Akses']);
    }
}
