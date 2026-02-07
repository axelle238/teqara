<?php

namespace App\Livewire\Pelanggan;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class PengaturanKeamanan extends Component
{
    public $sandi_lama;
    public $sandi_baru;
    public $sandi_baru_confirmation;

    public function gantiPassword()
    {
        $this->validate([
            'sandi_lama' => 'required|current_password',
            'sandi_baru' => 'required|min:8|confirmed|different:sandi_lama',
        ], [
            'sandi_lama.current_password' => 'Kata sandi saat ini tidak cocok.',
            'sandi_baru.min' => 'Kata sandi baru minimal 8 karakter.',
            'sandi_baru.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'sandi_baru.different' => 'Kata sandi baru harus berbeda dari yang lama.'
        ]);

        auth()->user()->update([
            'kata_sandi' => Hash::make($this->sandi_baru),
        ]);

        $this->reset(['sandi_lama', 'sandi_baru', 'sandi_baru_confirmation']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Keamanan akun berhasil diperbarui.']);
    }

    #[Title('Benteng Keamanan - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.pengaturan-keamanan')
            ->layout('components.layouts.app');
    }
}
