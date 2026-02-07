<?php

namespace App\Livewire\Pengelola;

use App\Models\Notifikasi;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class PusatNotifikasi
 * Tujuan: Inbox terpusat untuk semua alert sistem dan notifikasi operasional.
 */
class PusatNotifikasi extends Component
{
    use WithPagination;

    public $filterTipe = 'semua';

    public function markAsRead($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif) {
            $notif->update(['dibaca_pada' => now()]);
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Notifikasi ditandai dibaca.']);
        }
    }

    public function hapusSemua()
    {
        Notifikasi::untukSaya()->delete();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Inbox berhasil dibersihkan.']);
    }

    #[Title('Inbox Notifikasi - Admin Teqara')]
    public function render()
    {
        $query = Notifikasi::untukSaya()->latest('dibuat_pada');

        if ($this->filterTipe === 'penting') {
            $query->whereIn('tipe', ['peringatan', 'bahaya']);
        }

        return view('livewire.pengelola.pusat-notifikasi', [
            'notifikasi' => $query->paginate(15),
        ])->layout('components.layouts.admin', ['header' => 'Pusat Notifikasi']);
    }
}
