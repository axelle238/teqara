<?php

namespace App\Livewire\Pengelola\Log;

use App\Models\LogAktivitas;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Komponen Detail Log Aktivitas
 * 
 * Menampilkan rincian teknis dan naratif dari sebuah rekaman audit trail.
 */
class DetailLog extends Component
{
    public $logId;

    /**
     * Inisialisasi komponen dengan ID log.
     */
    public function mount($id)
    {
        $this->logId = $id;
    }

    /**
     * Mengambil data log beserta relasi pengguna.
     */
    public function getLogProperty()
    {
        return LogAktivitas::with('pengguna')->findOrFail($this->logId);
    }

    #[Title('Detail Rekam Jejak Audit - Teqara')]
    public function render()
    {
        return view('components.pengelola.log.⚡detail-log')
            ->layout('components.layouts.admin', ['header' => 'Rincian Log Aktivitas']);
    }
}
