<?php

namespace App\Livewire\Pelanggan\DaftarBelanja;

use App\Models\DaftarBelanja;
use App\Models\Keranjang;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailDaftar extends Component
{
    public DaftarBelanja $daftar;

    public function mount($id)
    {
        $this->daftar = DaftarBelanja::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->with(['items.produk'])
            ->firstOrFail();
    }

    public function masukkanKeranjang()
    {
        foreach ($this->daftar->items as $item) {
            $existing = Keranjang::where('pengguna_id', auth()->id())
                ->where('produk_id', $item->produk_id)
                ->first();

            if ($existing) {
                $existing->increment('jumlah', $item->jumlah);
            } else {
                Keranjang::create([
                    'pengguna_id' => auth()->id(),
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah
                ]);
            }
        }

        $this->dispatch('update-keranjang');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Semua item berhasil masuk keranjang!']);
        return redirect()->route('keranjang');
    }

    public function hapusItem($itemId)
    {
        $this->daftar->items()->where('id', $itemId)->delete();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Item dihapus dari daftar.']);
    }

    #[Title('Rincian Daftar Belanja - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.daftar-belanja.detail-daftar')
            ->layout('components.layouts.app');
    }
}
