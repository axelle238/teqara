<?php

namespace App\Livewire\Admin\Pengguna;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardPengguna extends Component
{
    #[Title('Dashboard Pengguna - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.pengguna.dashboard-pengguna', [
            'total_admin' => Pengguna::where('peran', 'admin')->count(),
            'total_staff' => Pengguna::where('peran', 'staff')->count(), // Asumsi ada peran staff nanti
            'daftar_admin' => Pengguna::whereIn('peran', ['admin', 'staff'])->latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
