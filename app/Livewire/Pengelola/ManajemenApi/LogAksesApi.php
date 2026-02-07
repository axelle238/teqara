<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Models\LogApi;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class LogAksesApi extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterMetode = '';
    public $filterStatus = '';

    public function updated($property)
    {
        if (in_array($property, ['cari', 'filterMetode', 'filterStatus'])) {
            $this->resetPage();
        }
    }

    #[Title('Log Aktivitas API - Teqara Admin')]
    public function render()
    {
        $logs = LogApi::with('kunciApi')
            ->when($this->cari, fn($q) => $q->where('endpoint', 'like', '%' . $this->cari . '%'))
            ->when($this->filterMetode, fn($q) => $q->where('metode', $this->filterMetode))
            ->when($this->filterStatus, function($q) {
                if ($this->filterStatus == 'success') $q->whereBetween('respons_kode', [200, 299]);
                if ($this->filterStatus == 'error') $q->where('respons_kode', '>=', 400);
            })
            ->latest('dibuat_pada')
            ->paginate(20);

        return view('livewire.pengelola.manajemen-api.log-akses-api', [
            'logs' => $logs
        ])->layout('components.layouts.admin', ['header' => 'Monitoring API']);
    }
}
