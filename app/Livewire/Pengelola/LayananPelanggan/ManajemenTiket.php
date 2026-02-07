<?php

namespace App\Livewire\Pengelola\LayananPelanggan;

use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenTiket extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $filterPrioritas = '';
    public $cari = '';

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    #[Title('Helpdesk & Support - Teqara Admin')]
    public function render()
    {
        $tiket = TiketBantuan::with(['pengguna'])
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterPrioritas, fn($q) => $q->where('prioritas', $this->filterPrioritas))
            ->when($this->cari, function($q) {
                $q->where('subjek', 'like', '%'.$this->cari.'%')
                  ->orWhere('id', 'like', '%'.$this->cari.'%')
                  ->orWhereHas('pengguna', fn($u) => $u->where('nama', 'like', '%'.$this->cari.'%'));
            })
            ->latest('diperbarui_pada') // Menggunakan kolom timestamp kustom
            ->paginate(10);

        $stats = [
            'total' => TiketBantuan::count(),
            'terbuka' => TiketBantuan::where('status', 'terbuka')->count(),
            'tinggi' => TiketBantuan::where('prioritas', 'tinggi')->where('status', '!=', 'selesai')->count(),
        ];

        return view('livewire.pengelola.layanan-pelanggan.manajemen-tiket', [
            'tiket' => $tiket,
            'stats' => $stats
        ])->layout('components.layouts.admin', ['header' => 'Pusat Bantuan (Helpdesk)']);
    }
}
