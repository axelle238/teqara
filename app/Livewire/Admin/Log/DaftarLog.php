<?php

namespace App\Livewire\Admin\Log;

use App\Models\LogAktivitas;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarLog extends Component
{
    use WithPagination;

    public $cari = '';

    public function updatedCari()
    {
        $this->resetPage();
    }

    #[Title('Log Aktivitas - Admin')]
    public function render()
    {
        $logs = LogAktivitas::with('pengguna')
            ->when($this->cari, function ($query) {
                $query->where('aksi', 'like', '%'.$this->cari.'%')
                    ->orWhere('target', 'like', '%'.$this->cari.'%')
                    ->orWhere('pesan_naratif', 'like', '%'.$this->cari.'%');
            })
            ->latest('waktu')
            ->paginate(20);

        return view('livewire.admin.log.daftar-log', [
            'logs' => $logs,
        ])->layout('components.layouts.admin', ['title' => 'Log Aktivitas Sistem']);
    }
}
