<?php

namespace App\Livewire\Pengelola\Log;

use App\Models\LogAktivitas;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarLog
 * Tujuan: Audit trail keamanan dan aktivitas sistem untuk transparansi operasional.
 */
class DaftarLog extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterUser = '';

    public function getLogProperty()
    {
        return LogAktivitas::with('pengguna')
            ->when($this->cari, function($q) {
                $q->where('aksi', 'like', '%'.$this->cari.'%')
                  ->orWhere('pesan_naratif', 'like', '%'.$this->cari.'%')
                  ->orWhere('target', 'like', '%'.$this->cari.'%');
            })
            ->when($this->filterUser, fn($q) => $q->where('pengguna_id', $this->filterUser))
            ->latest('waktu')
            ->paginate(20);
    }

    #[Title('Audit Log Sistem - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.log.daftar-log', [
            'users' => \App\Models\Pengguna::whereIn('peran', ['admin', 'editor', 'cs', 'gudang'])->get()
        ])->layout('components.layouts.admin', ['header' => 'Log Aktivitas']);
    }
}
