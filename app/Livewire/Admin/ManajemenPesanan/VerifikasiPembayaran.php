<?php

namespace App\Livewire\Admin\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\TransaksiPembayaran;
use App\Services\LayananGerbangPembayaran;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class VerifikasiPembayaran
 * Tujuan: Memvalidasi arus kas masuk dari berbagai gerbang pembayaran atau transfer manual.
 */
class VerifikasiPembayaran extends Component
{
    use WithPagination;

    public $filterStatus = 'menunggu';

    public function verifikasi($id)
    {
        $layanan = new LayananGerbangPembayaran();
        
        try {
            $layanan->prosesNotifikasi($id, 'sukses');
            
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran berhasil diverifikasi. Inventaris & Poin telah diperbarui.']);
        } catch (\Exception $e) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal memverifikasi: ' . $e->getMessage()]);
        }
    }

    public function tolak($id)
    {
        $layanan = new LayananGerbangPembayaran();
        
        try {
            $layanan->prosesNotifikasi($id, 'gagal');
            
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pembayaran telah ditolak.']);
        } catch (\Exception $e) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal menolak: ' . $e->getMessage()]);
        }
    }

    #[Title('Verifikasi Pembayaran - Admin Teqara')]
    public function render()
    {
        $transaksi = TransaksiPembayaran::query()
            ->with(['pesanan.pengguna'])
            ->whereIn('status', ['menunggu', 'sukses', 'gagal'])
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manajemen-pesanan.verifikasi-pembayaran', [
            'pembayaran' => $transaksi,
        ])->layout('components.layouts.admin');
    }
}
