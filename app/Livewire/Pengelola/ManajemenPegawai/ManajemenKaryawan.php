<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Models\Karyawan;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenKaryawan extends Component
{
    use WithPagination;

    public $tambahMode = false;
    
    // Form Input Akun
    public $nama;
    public $email;
    public $peran = 'admin';
    public $password;

    // Form Input Data Pegawai
    public $nip;
    public $jabatan_id;
    public $tanggal_bergabung;

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email|unique:pengguna,email',
            'peran' => 'required',
            'password' => 'required|min:8',
            'nip' => 'required|unique:karyawan,nip',
            'jabatan_id' => 'nullable|exists:jabatan,id',
        ]);

        DB::transaction(function () {
            // 1. Buat Akun Login
            $user = Pengguna::create([
                'nama' => $this->nama,
                'email' => $this->email,
                'peran' => $this->peran,
                'kata_sandi' => Hash::make($this->password),
                'email_diverifikasi_pada' => now(),
            ]);

            // 2. Buat Data Karyawan
            Karyawan::create([
                'pengguna_id' => $user->id,
                'nama_lengkap' => $this->nama,
                'nip' => $this->nip,
                'jabatan_id' => $this->jabatan_id,
                'tanggal_bergabung' => $this->tanggal_bergabung ?? now(),
                'status_karyawan' => 'tetap',
            ]);
        });

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Data personil berhasil diregistrasi (Akun + HRD).']);
        $this->reset(['nama', 'email', 'peran', 'password', 'nip', 'jabatan_id', 'tambahMode']);
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
        $karyawan = Karyawan::with(['pengguna', 'jabatan.departemen'])
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-pegawai.manajemen-karyawan', [
            'karyawan' => $karyawan,
            'daftarJabatan' => \App\Models\Jabatan::all()
        ])->layout('components.layouts.admin', ['header' => 'Manajemen SDM']);
    }
}
