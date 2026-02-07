<?php

namespace App\Livewire\Pelanggan\Langganan;

use App\Models\Langganan;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailLangganan extends Component
{
    public Langganan $langganan;

    public function mount($id)
    {
        $this->langganan = Langganan::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->with('produk')
            ->firstOrFail();
    }

    public function batalkanLangganan()
    {
        $this->langganan->update(['status' => 'dibatalkan']);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Langganan berhasil dibatalkan.']);
    }

    public function aktifkanKembali()
    {
        $this->langganan->update(['status' => 'aktif']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Langganan diaktifkan kembali.']);
    }

    #[Title('Detail Langganan - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.langganan.detail-langganan')
            ->layout('components.layouts.app');
    }
}
