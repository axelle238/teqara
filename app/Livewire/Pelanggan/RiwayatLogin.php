<?php

namespace App\Livewire\Pelanggan;

use App\Models\LogAktivitas;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatLogin extends Component
{
    use WithPagination;

    public function getRiwayatProperty()
    {
        // Assuming we log logins with action 'login'
        return LogAktivitas::where('pengguna_id', auth()->id())
            ->whereIn('aksi', ['login', 'logout', 'ganti_sandi', 'update_profil'])
            ->latest('waktu')
            ->paginate(15);
    }

    #[Title('Aktivitas Keamanan - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.riwayat-login')
            ->layout('components.layouts.app');
    }
}
