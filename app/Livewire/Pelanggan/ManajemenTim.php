<?php

namespace App\Livewire\Pelanggan;

use App\Models\AnggotaTim;
use Livewire\Attributes\Title;
use Livewire\Component;

class ManajemenTim extends Component
{
    public $tambahMode = false;
    public $nama;
    public $email;
    public $peran = 'staf'; // admin, keuangan, staf

    public function getAnggotaTimSayaProperty()
    {
        return AnggotaTim::where('pemilik_id', auth()->id())->latest()->get();
    }

    public function tambahAnggota()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email|unique:anggota_tim,email',
            'peran' => 'required'
        ]);

        AnggotaTim::create([
            'pemilik_id' => auth()->id(),
            'nama' => $this->nama,
            'email' => $this->email,
            'peran' => $this->peran,
            'status' => 'aktif'
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Anggota tim berhasil diundang.']);
        $this->reset(['nama', 'email', 'peran', 'tambahMode']);
    }

    public function hapus($id)
    {
        AnggotaTim::where('id', $id)->where('pemilik_id', auth()->id())->delete();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Akses anggota dicabut.']);
    }

    #[Title('Manajemen Tim - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.manajemen-tim')
            ->layout('components.layouts.app');
    }
}
