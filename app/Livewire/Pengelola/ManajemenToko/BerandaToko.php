<?php

namespace App\Livewire\Pengelola\ManajemenToko;

use App\Models\KontenHalaman;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class BerandaToko
 * Tujuan: Beranda pilar Manajemen Halaman Toko.
 */
class BerandaToko extends Component
{
    #[Title('Manajemen Halaman Toko - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-toko.beranda-toko', [
            'total_banner' => KontenHalaman::where('bagian', 'hero_section')->count(),
            'total_promo' => KontenHalaman::where('bagian', 'promo_banner')->count(),
            'konten_terbaru' => KontenHalaman::latest('diperbarui_pada')->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
