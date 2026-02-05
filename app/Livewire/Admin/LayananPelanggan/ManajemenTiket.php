<?php

namespace App\Livewire\Admin\LayananPelanggan;

use App\Helpers\LogHelper;
use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenTiket
 * Tujuan: Manajemen tiket bantuan dan keluhan pelanggan.
 */
class ManajemenTiket extends Component
{
    use WithPagination;

    public $filterStatus = 'terbuka';

    public function tutupTiket($id)
    {
        $tiket = TiketBantuan::findOrFail($id);
        $tiket->update(['status' => 'selesai']);

        LogHelper::catat('tutup_tiket', $tiket->nomor_tiket, "Admin menyelesaikan tiket bantuan #{$tiket->nomor_tiket}.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Tiket bantuan telah diselesaikan.']);
    }

    #[Title('Tiket Bantuan - Admin Teqara')]
    public function render()
    {
        try {
            $tiket = TiketBantuan::with('pengguna')
                ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
                ->latest()
                ->paginate(10);
        } catch (\Exception $e) {
            $tiket = collect([]);
        }

        return view('livewire.admin.layanan-pelanggan.manajemen-tiket', [
            'tiket' => $tiket,
        ])->layout('components.layouts.admin');
    }
}
