<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

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

            // Cek peran, arahkan sesuai hak akses
            if (auth()->user()->peran === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'Kombinasi email dan kata sandi tidak cocok.');
    }

    #[Title('Masuk - Teqara')]
    public function render()
    {
        return view('livewire.auth.masuk')
            ->layout('components.layouts.app', ['title' => 'Masuk - Teqara']);
    }
}
