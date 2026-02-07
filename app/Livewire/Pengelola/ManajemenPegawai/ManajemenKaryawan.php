<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenKaryawan extends Component
{
    use WithPagination;

    public $tambahMode = false;
    
    // Form Input
    public $nama;
    public $email;
    public $peran = 'admin'; // admin, editor, cs, gudang
    public $password;

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email|unique:pengguna,email',
            'peran' => 'required',
            'password' => 'required|min:8',
        ]);

        Pengguna::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'peran' => $this->peran, // Pastikan middleware mengenali peran ini
            'kata_sandi' => Hash::make($this->password),
            'email_diverifikasi_pada' => now(),
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Karyawan baru berhasil ditambahkan.']);
        $this->reset(['nama', 'email', 'peran', 'password', 'tambahMode']);
    }

    public function hapus($id)
    {
        if ($id == auth()->id()) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Anda tidak dapat menghapus akun sendiri.']);
            return;
        }

        Pengguna::destroy($id);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Akun karyawan dihapus.']);
    }

    #[Title('Manajemen SDM (HRD) - Teqara Admin')]
    public function render()
    {
        $karyawan = Pengguna::whereIn('peran', ['admin', 'editor', 'cs', 'gudang'])
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-pegawai.manajemen-karyawan', [
            'karyawan' => $karyawan
        ])->layout('components.layouts.admin', ['header' => 'Manajemen SDM']);
    }
}
