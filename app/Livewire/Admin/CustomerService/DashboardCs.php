<?php

namespace App\Livewire\Admin\CustomerService;

use App\Models\Ulasan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardCs extends Component
{
    #[Title('Dashboard Customer Service - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.customer-service.dashboard-cs', [
            'total_ulasan' => Ulasan::count(),
            'rating_rata' => Ulasan::avg('rating') ?? 0,
            'ulasan_terbaru' => Ulasan::with(['pengguna', 'produk'])->latest()->take(5)->get(),
        ])->layout('components.layouts.admin');
    }
}
