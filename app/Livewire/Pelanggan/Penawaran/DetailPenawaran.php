<?php

namespace App\Livewire\Pelanggan\Penawaran;

use App\Models\PenawaranHarga;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailPenawaran extends Component
{
    public PenawaranHarga $penawaran;

    public function mount($id)
    {
        $this->penawaran = PenawaranHarga::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->with(['items.produk'])
            ->firstOrFail();
    }

    public function terimaTawaran()
    {
        // Logic untuk mengubah status jadi disetujui (oleh user) dan mungkin membuat pesanan draft
        // Disini kita hanya update status dulu sebagai simulasi flow
        
        $this->penawaran->update(['status' => 'disetujui']);
        
        // Todo: Convert to Order logic here
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Penawaran diterima! Silakan lanjut ke pembayaran.']);
    }

    public function tolakTawaran()
    {
        $this->penawaran->update(['status' => 'ditolak']);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Penawaran ditolak.']);
    }

    #[Title('Detail RFQ - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.penawaran.detail-penawaran')
            ->layout('components.layouts.app');
    }
}
