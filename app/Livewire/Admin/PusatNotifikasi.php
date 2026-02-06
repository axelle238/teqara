<?php

namespace App\Livewire\Admin;

use App\Models\LogAktivitas;
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
        // Simulasi mark as read (karena tabel notifikasi belum ada, kita pakai log aktivitas sebagai proxy)
        // Di sistem nyata, ini akan update tabel 'notifications'
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Notifikasi ditandai dibaca.']);
    }

    public function hapusSemua()
    {
        // Simulasi hapus
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Inbox dibersihkan.']);
    }

    #[Title('Inbox Notifikasi - Admin Teqara')]
    public function render()
    {
        // Menggunakan LogAktivitas sebagai sumber data notifikasi sementara
        // Filter log penting saja (bukan sekedar login)
        $query = LogAktivitas::whereIn('aksi', ['buat_pesanan', 'stok_kritis', 'tiket_baru', 'system_lock', 'hapus_massal_produk'])
            ->latest('waktu');

        if ($this->filterTipe === 'penting') {
            $query->whereIn('aksi', ['stok_kritis', 'system_lock']);
        }

        return view('livewire.admin.pusat-notifikasi', [
            'notifikasi' => $query->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
