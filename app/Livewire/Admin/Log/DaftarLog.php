<?php

namespace App\Livewire\Admin\Log;

use App\Models\LogAktivitas;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarLog
 * Tujuan: Rekaman forensik aktivitas digital seluruh aktor sistem.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class DaftarLog extends Component
{
    use WithPagination;

    // State Halaman
    public $tampilkanDetail = false;

    // Filter
    public $cari = '';

    // Properti Model
    public $logTerpilih;

    /**
     * Reset pagination saat pencarian berubah.
     */
    public function updatedCari()
    {
        $this->resetPage();
    }

    /**
     * Beralih ke tampilan detail aktivitas (Halaman Penuh).
     */
    public function lihatDetail($id)
    {
        $this->logTerpilih = LogAktivitas::with('pengguna')->findOrFail($id);
        $this->tampilkanDetail = true;
    }

    /**
     * Kembali ke daftar log utama.
     */
    public function kembali()
    {
        $this->tampilkanDetail = false;
        $this->reset(['logTerpilih']);
    }

    #[Title('Log Jejak Digital - Teqara')]
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