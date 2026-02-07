<?php

namespace App\Livewire\Produk;

use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;

class Bandingkan extends Component
{
    public function getProdukListProperty()
    {
        $ids = session()->get('bandingkan_produk', []);
        return Produk::whereIn('id', $ids)->with(['spesifikasi', 'kategori'])->get();
    }

    public function hapus($id)
    {
        $ids = session()->get('bandingkan_produk', []);
        $ids = array_diff($ids, [$id]);
        session()->put('bandingkan_produk', $ids);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Produk dihapus dari perbandingan.']);
    }

    public function hapusSemua()
    {
        session()->forget('bandingkan_produk');
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Daftar perbandingan dikosongkan.']);
    }

    public function tambahKeKeranjang($produkId)
    {
        // Emit ke global listener atau panggil logic keranjang
        // Untuk sederhananya kita redirect ke detail dulu atau emit event jika ada global cart listener
        return redirect()->route('produk.detail', Produk::find($produkId)->slug);
    }

    #[Title('Bandingkan Produk - Teqara')]
    public function render()
    {
        return view('livewire.produk.bandingkan')
            ->layout('components.layouts.app');
    }
}