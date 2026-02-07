<?php

namespace App\Livewire\Pelanggan\DaftarBelanja;

use App\Models\DaftarBelanja;
use Livewire\Attributes\Title;
use Livewire\Component;

class SemuaDaftar extends Component
{
    public $nama_baru;

    public function getDaftarSayaProperty()
    {
        return DaftarBelanja::where('pengguna_id', auth()->id())
            ->withCount('items')
            ->latest()
            ->get();
    }

    public function buatDaftar()
    {
        $this->validate(['nama_baru' => 'required|min:3|max:50']);

        DaftarBelanja::create([
            'pengguna_id' => auth()->id(),
            'nama_daftar' => $this->nama_baru,
        ]);

        $this->reset('nama_baru');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Daftar belanja baru dibuat.']);
    }

    public function hapus($id)
    {
        DaftarBelanja::where('id', $id)->where('pengguna_id', auth()->id())->delete();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Daftar belanja dihapus.']);
    }

    #[Title('Daftar Belanja Rutin - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.daftar-belanja.semua-daftar')
            ->layout('components.layouts.app');
    }
}
