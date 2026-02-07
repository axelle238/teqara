<?php

namespace App\Livewire\Otentikasi;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class Daftar extends Component
{
    public $nama;
    public $email;
    public $kata_sandi;
    public $konfirmasi_kata_sandi;

    public function daftar()
    {
        $this->validate([
            'nama' => 'required|min:3|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'kata_sandi' => 'required|min:8|same:konfirmasi_kata_sandi',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'kata_sandi' => Hash::make($this->kata_sandi),
            'peran' => 'pelanggan',
            'status' => 'aktif',
            'poin_loyalitas' => 0,
        ]);

        Auth::login($pengguna);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Registrasi berhasil! Selamat datang di Teqara.']);

        return redirect()->to('/');
    }

    #[Title('Daftar Otoritas Baru - Teqara')]
    public function render()
    {
        return view('livewire.otentikasi.daftar')
            ->layout('components.layouts.app');
    }
}
