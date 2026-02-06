<?php

namespace App\Livewire\Pengelola\ManajemenVendor;

use App\Models\Pemasok;
use App\Models\PembelianStok;
use Livewire\Attributes\Title;
use Livewire\Component;

class BerandaVendor extends Component
{
    #[Title('Dashboard Manajemen Vendor - Teqara Enterprise')]
    public function render()
    {
        $stats = [
            'total_vendor' => Pemasok::count(),
            'vendor_aktif' => Pemasok::where('status', 'aktif')->count(),
            'po_menunggu' => PembelianStok::where('status', 'menunggu_persetujuan')->count(),
            'total_po' => PembelianStok::count(),
        ];

        return view('livewire.pengelola.manajemen-vendor.beranda-vendor', [
            'stats' => $stats
        ])->layout('components.layouts.admin');
    }
}
