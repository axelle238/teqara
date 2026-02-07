<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;

class PengaturanNotifikasi extends Component
{
    public $notifikasi_transaksi = true;
    public $notifikasi_promo = true;
    public $newsletter_email = true;

    // Di real app, simpan ini di tabel users atau user_settings
    // public function mount() { ... load settings ... }

    public function simpan()
    {
        // Auth::user()->update([...]);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Preferensi notifikasi diperbarui.']);
    }

    #[Title('Pengaturan Notifikasi - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.pengaturan-notifikasi')
            ->layout('components.layouts.app');
    }
}
