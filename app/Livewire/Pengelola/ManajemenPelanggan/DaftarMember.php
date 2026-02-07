<?php

namespace App\Livewire\Pengelola\ManajemenPelanggan;

use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarMember extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterLevel = ''; // Classic, Silver, Gold, Platinum

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function getPelangganProperty()
    {
        return Pengguna::where('peran', 'pelanggan')
            ->where(function($q) {
                $q->where('nama', 'like', '%' . $this->cari . '%')
                  ->orWhere('email', 'like', '%' . $this->cari . '%');
            })
            ->when($this->filterLevel, function($q) {
                $q->where('level_member', $this->filterLevel);
            })
            ->withCount('pesanan')
            ->withSum('pesanan as total_belanja', 'total_harga')
            ->latest('dibuat_pada')
            ->paginate(12);
    }

    #[Title('Data Pelanggan (CRM) - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-pelanggan.daftar-member')
            ->layout('components.layouts.admin', ['header' => 'Customer Relationship']);
    }
}
