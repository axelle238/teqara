<?php

namespace App\Livewire\Pelanggan;

use App\Models\KunciApi;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Str;

class AksesApi extends Component
{
    public $tambahMode = false;
    public $nama_token;
    public $token_baru;

    public function getKunciApiProperty()
    {
        return KunciApi::where('pengguna_id', auth()->id())->latest()->get();
    }

    public function buatToken()
    {
        $this->validate(['nama_token' => 'required|min:3']);

        $token = 'teq_' . Str::random(40);

        KunciApi::create([
            'pengguna_id' => auth()->id(),
            'nama_token' => $this->nama_token,
            'token' => hash('sha256', $token), // Simpan hash
            'terakhir_dipakai' => null,
        ]);

        $this->token_baru = $token; // Tampilkan token asli sekali saja
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kunci API berhasil dibuat.']);
        $this->reset(['nama_token']);
    }

    public function hapus($id)
    {
        KunciApi::where('id', $id)->where('pengguna_id', auth()->id())->delete();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Kunci API dicabut.']);
    }

    #[Title('Integrasi API - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.akses-api')
            ->layout('components.layouts.app');
    }
}
