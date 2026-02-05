<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class Profil extends Component
{
    public $nama;

    public $email;

    public $nomor_telepon;

    public function mount()
    {
        $pengguna = auth()->user();
        $this->nama = $pengguna->nama;
        $this->email = $pengguna->email;
        $this->nomor_telepon = $pengguna->nomor_telepon;
    }

    public function simpanProfil()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'nomor_telepon' => 'nullable|numeric',
        ]);

        auth()->user()->update([
            'nama' => $this->nama,
            'nomor_telepon' => $this->nomor_telepon,
        ]);

        $this->dispatch('notifikasi', [
            'tipe' => 'sukses',
            'pesan' => 'Profil Anda berhasil diperbarui.',
        ]);
    }

    #[Title('Dashboard Saya - Teqara')]
    public function render()
    {
        $pesananTerakhir = Pesanan::where('pengguna_id', auth()->id())
            ->latest()
            ->take(3)
            ->get();

        $totalBelanja = Pesanan::where('pengguna_id', auth()->id())
            ->where('status_pembayaran', 'lunas')
            ->sum('total_harga');

        return view('livewire.pelanggan.profil', [
            'pesananTerakhir' => $pesananTerakhir,
            'totalBelanja' => $totalBelanja,
        ])->layout('components.layouts.app');
    }
}
