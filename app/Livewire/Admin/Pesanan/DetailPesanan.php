<?php

namespace App\Livewire\Admin\Pesanan;

use Livewire\Component;
use App\Models\Pesanan;
use App\Models\LogAktivitas;
use Livewire\Attributes\Title;

class DetailPesanan extends Component
{
    public Pesanan $pesanan;
    public $statusPesanan;
    public $statusPembayaran;
    public $resiPengiriman;

    public function mount(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan->load(['detailPesanan.produk', 'pengguna']);
        $this->statusPesanan = $pesanan->status_pesanan;
        $this->statusPembayaran = $pesanan->status_pembayaran;
        $this->resiPengiriman = $pesanan->resi_pengiriman;
    }

    public function simpanPerubahan()
    {
        $pesananLama = $this->pesanan->replicate();
        
        $this->pesanan->update([
            'status_pesanan' => $this->statusPesanan,
            'status_pembayaran' => $this->statusPembayaran,
            'resi_pengiriman' => $this->resiPengiriman,
        ]);

        // Catat Log jika ada perubahan
        if ($pesananLama->status_pesanan !== $this->statusPesanan) {
            $this->catatLog("Mengubah status pesanan dari {$pesananLama->status_pesanan} menjadi {$this->statusPesanan}");
        }

        if ($pesananLama->status_pembayaran !== $this->statusPembayaran) {
            $this->catatLog("Mengubah status pembayaran dari {$pesananLama->status_pembayaran} menjadi {$this->statusPembayaran}");
        }

        $this->dispatch('notifikasi', [
            'tipe' => 'sukses',
            'pesan' => 'Data pesanan berhasil diperbarui.'
        ]);
    }

    private function catatLog($pesan)
    {
        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'update_pesanan',
            'target' => $this->pesanan->nomor_invoice,
            'pesan_naratif' => "Admin " . auth()->user()->nama . " {$pesan} pada invoice {$this->pesanan->nomor_invoice}",
            'waktu' => now()
        ]);
    }

    #[Title('Detail Pesanan - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.pesanan.detail-pesanan')
            ->layout('components.layouts.admin', ['title' => 'Proses Pesanan']);
    }
}
