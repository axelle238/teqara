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

    public $logTerpilih;

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function lihatDetail($id)
    {
        $this->logTerpilih = LogAktivitas::with('pengguna')->find($id);
        $this->dispatch('open-slide-over', id: 'detail-log');
    }

    #[Title('Audit Log Aktivitas - Admin Teqara')]
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
        ])->layout('components.layouts.admin');
    }
}
