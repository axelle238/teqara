<?php

namespace App\Livewire\Pelanggan;

use App\Models\Notifikasi as ModelNotifikasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Pusat Notifikasi Pelanggan
 * 
 * Menampilkan seluruh pemberitahuan sistem, transaksi, dan promo khusus pelanggan.
 * Mendukung filter tipe dan penandaan status baca secara real-time.
 */
class Notifikasi extends Component
{
    use WithPagination;

    public $filter = 'semua'; // semua, transaksi, info, promo

    /**
     * Reset paginasi saat filter berubah.
     */
    public function updatedFilter()
    {
        $this->resetPage();
    }

    /**
     * Menandai satu notifikasi sebagai telah dibaca.
     */
    public function tandaiDibaca($id)
    {
        $notif = ModelNotifikasi::untukSaya()->findOrFail($id);
        if (!$notif->dibaca_pada) {
            $notif->update(['dibaca_pada' => now()]);
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Notifikasi ditandai dibaca.']);
        }
    }

    /**
     * Menandai seluruh notifikasi milik pengguna sebagai telah dibaca.
     */
    public function tandaiSemuaDibaca()
    {
        ModelNotifikasi::untukSaya()
            ->belumDibaca()
            ->update(['dibaca_pada' => now()]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Semua notifikasi ditandai sudah dibaca.']);
    }

    /**
     * Mengambil data notifikasi dari database dengan filter dan paginasi.
     */
    public function render()
    {
        $query = ModelNotifikasi::untukSaya()
            ->latest('dibuat_pada');

        if ($this->filter !== 'semua') {
            $query->where('tipe', $this->filter);
        }

        $daftar_notifikasi = $query->paginate(10);

        return view('livewire.pelanggan.notifikasi', [
            'notifikasi' => $daftar_notifikasi
        ])->layout('components.layouts.app');
    }
}