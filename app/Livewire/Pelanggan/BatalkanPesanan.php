<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class BatalkanPesanan extends Component
{
    public Pesanan $pesanan;
    public $alasan;
    public $keterangan;

    public function mount($id)
    {
        $this->pesanan = Pesanan::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->whereIn('status_pesanan', ['menunggu', 'diproses']) // Hanya bisa batal jika belum dikirim
            ->firstOrFail();
    }

    public function batalkan()
    {
        $this->validate([
            'alasan' => 'required',
            'keterangan' => 'nullable|min:10',
        ]);

        $this->pesanan->update([
            'status_pesanan' => 'batal',
            'alasan_pembatalan' => $this->alasan . " - " . $this->keterangan,
            'waktu_pembatalan' => now(),
        ]);

        // Kembalikan stok
        (new \App\Services\LayananStok)->kembalikanStok($this->pesanan);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesanan berhasil dibatalkan.']);
        return redirect()->route('pesanan.riwayat');
    }

    #[Title('Batalkan Pesanan - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.batalkan-pesanan')
            ->layout('components.layouts.app');
    }
}
