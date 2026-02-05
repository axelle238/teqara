<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class Profil extends Component
{
    // Tab State
    public $tabAktif = 'ringkasan'; // ringkasan, pesanan, pengaturan_sistem

    // Data Diri
    public $nama;

    public $email;

    public $nomor_telepon;

    // Ganti Password
    public $sandi_lama;

    public $sandi_baru;

    public $sandi_baru_confirmation;

    public function mount()
    {
        $pengguna = auth()->user();
        $this->nama = $pengguna->nama;
        $this->email = $pengguna->email;
        $this->nomor_telepon = $pengguna->nomor_telepon;
    }

    public function gantiTab($tab)
    {
        $this->tabAktif = $tab;
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

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Profil berhasil diperbarui.']);
    }

    public function gantiPassword()
    {
        $this->validate([
            'sandi_lama' => 'required|current_password',
            'sandi_baru' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update([
            'kata_sandi' => Hash::make($this->sandi_baru),
        ]);

        $this->reset(['sandi_lama', 'sandi_baru', 'sandi_baru_confirmation']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kata sandi berhasil diubah.']);
    }

    #[Title('Akun Saya - Teqara')]
    public function render()
    {
        $pesananTerakhir = Pesanan::where('pengguna_id', auth()->id())
            ->with(['detailPesanan.produk'])
            ->latest()
            ->take(5)
            ->get();

        $totalBelanja = Pesanan::where('pengguna_id', auth()->id())
            ->where('status_pembayaran', 'lunas')
            ->sum('total_harga');

        $jumlahPesanan = Pesanan::where('pengguna_id', auth()->id())->count();

        return view('livewire.pelanggan.profil', [
            'pesananTerakhir' => $pesananTerakhir,
            'totalBelanja' => $totalBelanja,
            'jumlahPesanan' => $jumlahPesanan,
        ])->layout('components.layouts.app');
    }
}
