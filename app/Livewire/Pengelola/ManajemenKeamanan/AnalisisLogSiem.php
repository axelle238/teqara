<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use App\Models\LogAktivitas;
use App\Models\LogApi;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AnalisisLogSiem extends Component
{
    use WithPagination;

    public $filterTipe = 'semua';
    public $search = '';
    public $tingkatKeparahan = 'semua';

    protected $queryString = ['filterTipe', 'search', 'tingkatKeparahan'];

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function getLogs()
    {
        if ($this->filterTipe === 'api') {
            return LogApi::latest('dibuat_pada')
                ->when($this->search, fn($q) => $q->where('endpoint', 'like', "%{$this->search}%")->orWhere('ip_address', 'like', "%{$this->search}%"))
                ->paginate(20);
        }

        return LogAktivitas::latest('waktu')
            ->when($this->search, function($q) {
                $q->where('aksi', 'like', "%{$this->search}%")
                  ->orWhere('meta_data->alamat_ip', 'like', "%{$this->search}%");
            })
            ->paginate(20);
    }

    #[Title('SIEM - Analisis Log Terpusat - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.analisis-log-siem', [
            'logs' => $this->getLogs()
        ])->layout('components.layouts.admin');
    }
}
