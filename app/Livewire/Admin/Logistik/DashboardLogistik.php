<?php

namespace App\Livewire\Admin\Logistik;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardLogistik extends Component
{
    #[Title('Dashboard Logistik - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.logistik.dashboard-logistik', [
            'siap_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'sedang_dikirim' => Pesanan::where('status_pesanan', 'dikirim')->count(),
            'sampai_tujuan' => Pesanan::where('status_pesanan', 'selesai')->count(),
        ])->layout('components.layouts.admin');
    }
}
