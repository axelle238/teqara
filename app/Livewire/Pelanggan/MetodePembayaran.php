<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;

class MetodePembayaran extends Component
{
    public $tambahMode = false;
    public $jenis_kartu = 'credit';
    public $nomor_kartu;
    public $nama_pemilik;
    public $expiry;
    public $cvv;

    public function getMetodeTersimpanProperty()
    {
        // Mockup data. In real app, this would query a 'user_payment_methods' table linked to Payment Gateway tokens (e.g., Stripe/Midtrans token)
        // NEVER store raw credit card numbers in DB.
        return collect([
            ['id' => 1, 'jenis' => 'Visa', 'last4' => '4242', 'exp' => '12/28', 'holder' => strtoupper(auth()->user()->nama)],
            ['id' => 2, 'jenis' => 'Mastercard', 'last4' => '8888', 'exp' => '09/25', 'holder' => strtoupper(auth()->user()->nama)],
        ]);
    }

    public function tambahBaru()
    {
        $this->tambahMode = true;
    }

    public function simpan()
    {
        $this->validate([
            'nomor_kartu' => 'required|numeric|digits:16',
            'nama_pemilik' => 'required|string|min:3',
            'expiry' => 'required',
            'cvv' => 'required|numeric|digits:3',
        ]);

        // Logic simpan token ke Payment Gateway
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Metode pembayaran berhasil ditambahkan (Simulasi).']);
        $this->tambahMode = false;
        $this->reset(['nomor_kartu', 'nama_pemilik', 'expiry', 'cvv']);
    }

    public function hapus($id)
    {
        // Logic hapus
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Metode pembayaran dihapus.']);
    }

    #[Title('Metode Pembayaran - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.metode-pembayaran')
            ->layout('components.layouts.app');
    }
}
