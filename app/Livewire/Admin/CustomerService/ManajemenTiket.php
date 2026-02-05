<?php

namespace App\Livewire\Admin\CustomerService;

use App\Helpers\LogHelper;
use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenTiket extends Component
{
    use WithPagination;

    public $filterStatus = 'terbuka';

    public function tutupTiket($id)
    {
        $tiket = TiketBantuan::findOrFail($id);
        $tiket->update(['status' => 'selesai']);

        LogHelper::catat('close_ticket', $tiket->nomor_tiket, "Admin menutup tiket bantuan #{$tiket->nomor_tiket}.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Tiket bantuan telah diselesaikan.']);
    }

    #[Title('Tiket Bantuan - Admin Teqara')]
    public function render()
    {
        // Simulasi jika tabel belum ada atau kosong
        try {
            $tiket = TiketBantuan::with('pengguna')
                ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
                ->latest()
                ->paginate(10);
        } catch (\Exception $e) {
            $tiket = collect([]);
        }

        return view('livewire.admin.customer-service.manajemen-tiket', [
            'tiket' => $tiket,
        ])->layout('components.layouts.admin');
    }
}
