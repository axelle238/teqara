<?php

namespace App\Livewire\Otentikasi;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class Masuk
 * Tujuan: Kendali otoritas akses (Login) pelanggan dan administrator.
 */
class Masuk extends Component
{
    public $email = '';

    public $kata_sandi = '';

    public $ingat_saya = false;

    public function masuk()
    {
        $this->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->kata_sandi], $this->ingat_saya)) {
            session()->regenerate();

            if (auth()->user()->peran === 'admin') {
                return redirect()->intended('/admin/beranda');
            }

            if (auth()->user()->peran === 'pemasok') {
                return redirect()->intended('/mitra/beranda');
            }

            return redirect()->intended('/profil');
        }

        $this->addError('email', 'Kombinasi otoritas tidak valid.');
    }

    #[Title('Masuk - Teqara Hub')]
    public function render()
    {
        return view('livewire.otentikasi.masuk')
            ->layout('components.layouts.app', ['title' => 'Masuk - Teqara Hub']);
    }
}
