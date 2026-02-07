<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;

class PusatPrivasi extends Component
{
    public $konfirmasiHapus = '';

    public function unduhData()
    {
        // Simulasi proses export data
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Permintaan data Anda sedang diproses. Link unduhan akan dikirim ke email.']);
    }

    public function hapusAkun()
    {
        if ($this->konfirmasiHapus !== 'HAPUS') {
            $this->addError('konfirmasiHapus', 'Ketik HAPUS untuk mengonfirmasi.');
            return;
        }

        // Logic hapus akun (soft delete)
        // auth()->user()->delete();
        // auth()->logout();
        
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Permintaan penghapusan akun diterima dan akan diproses dalam 14 hari.']);
        $this->reset('konfirmasiHapus');
    }

    #[Title('Pusat Privasi & Data - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.pusat-privasi')
            ->layout('components.layouts.app');
    }
}
