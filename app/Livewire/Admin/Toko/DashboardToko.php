<?php

namespace App\Livewire\Admin\Toko;

use App\Models\CmsKonten;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardToko extends Component
{
    #[Title('Manajemen Halaman Toko - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.toko.dashboard-toko', [
            'total_banner' => CmsKonten::where('bagian', 'hero_section')->count(),
            'total_promo' => CmsKonten::where('bagian', 'promo_banner')->count(),
            'konten_terbaru' => CmsKonten::latest('updated_at')->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
