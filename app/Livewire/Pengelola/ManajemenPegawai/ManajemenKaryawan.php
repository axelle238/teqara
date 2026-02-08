<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Helpers\LogHelper;
use App\Models\Karyawan;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenKaryawan
 * Tujuan: CRUD lengkap data pegawai (Data Akun + Data HRD) dalam satu halaman.
 */
class ManajemenKaryawan extends Component
{
    use WithPagination;

    public $tampilkanForm = false;
    public $karyawanId; // ID Tabel Karyawan
    public $userId;     // ID Tabel Pengguna
    public $cari = '';

    // Form Input Akun (Tabel Pengguna)
    public $nama;
    public $email;
    public $peran = 'admin';
    public $password; // Hanya diisi jika ganti/buat baru

    // Form Input HRD (Tabel Karyawan)
    public $nip;
    public $jabatan_id;
    public $telepon;
    public $alamat;
    public $tanggal_bergabung;
    public $status_kerja = 'tetap'; // kontrak, tetap, magang
    public $status_aktif = 'aktif'; // aktif, cuti, keluar

    public function tambahBaru()
    {
        $this->reset();
        $this->tampilkanForm = true;
        $this->tanggal_bergabung = date('Y-m-d');
        // Auto-generate NIP dummy
        $this->nip = date('Ym') . rand(100, 999); 
    }

    public function edit($id)
    {
        $k = Karyawan::with('pengguna')->findOrFail($id);
        
        $this->karyawanId = $k->id;
        $this->userId = $k->pengguna_id;
        
        // Data Akun
        $this->nama = $k->pengguna->nama ?? $k->nama_lengkap;
        $this->email = $k->pengguna->email ?? '';
        $this->peran = $k->pengguna->peran ?? 'admin';
        $this->telepon = $k->pengguna->nomor_telepon ?? $k->telepon;

        // Data HRD
        $this->nip = $k->nip;
        $this->jabatan_id = $k->jabatan_id;
        $this->alamat = $k->alamat;
        $this->tanggal_bergabung = $k->tanggal_bergabung;
        $this->status_kerja = $k->status_kerja;
        $this->status_aktif = $k->status;

        $this->tampilkanForm = true;
    }

    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset();
    }

    public function simpan()
    {
        // Validasi Dasar
        $rules = [
            'nama' => 'required|min:3',
            'peran' => 'required',
            'nip' => 'required|unique:karyawan,nip,' . $this->karyawanId,
            'jabatan_id' => 'nullable|exists:jabatan,id',
        ];

        if (!$this->karyawanId) {
            $rules['email'] = 'required|email|unique:pengguna,email';
            $rules['password'] = 'required|min:8';
        } else {
            $rules['email'] = 'required|email|unique:pengguna,email,' . $this->userId;
            $rules['password'] = 'nullable|min:8'; // Opsional saat edit
        }

        $this->validate($rules);

        DB::transaction(function () {
            // 1. Kelola Akun Login
            $dataAkun = [
                'nama' => $this->nama,
                'email' => $this->email,
                'peran' => $this->peran,
                'nomor_telepon' => $this->telepon,
            ];

            if ($this->password) {
                $dataAkun['kata_sandi'] = Hash::make($this->password);
            }

            if ($this->userId) {
                $user = Pengguna::find($this->userId);
                $user->update($dataAkun);
            } else {
                $dataAkun['email_diverifikasi_pada'] = now();
                $user = Pengguna::create($dataAkun);
                $this->userId = $user->id;
            }

            // 2. Kelola Data Karyawan
            $dataHRD = [
                'pengguna_id' => $this->userId,
                'nama_lengkap' => $this->nama,
                'nip' => $this->nip,
                'jabatan_id' => $this->jabatan_id,
                'telepon' => $this->telepon,
                'alamat' => $this->alamat,
                'tanggal_bergabung' => $this->tanggal_bergabung,
                'status_kerja' => $this->status_kerja,
                'status' => $this->status_aktif,
            ];

            if ($this->karyawanId) {
                Karyawan::find($this->karyawanId)->update($dataHRD);
                $aksi = 'update_karyawan';
                $pesan = "Memperbarui data personil: {$this->nama}";
            } else {
                Karyawan::create($dataHRD);
                $aksi = 'rekrutmen_staf';
                $pesan = "Mendaftarkan personil baru: {$this->nama}";
            }

            LogHelper::catat($aksi, $this->nip, $pesan);
        });

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Data personil berhasil disimpan.']);
        $this->batal();
    }

    public function hapus($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        
        if ($karyawan->pengguna_id == auth()->id()) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Anda tidak dapat menghapus diri sendiri.']);
            return;
        }

        // Hapus Akun & Data Karyawan (Cascade)
        if ($karyawan->pengguna) {
            $karyawan->pengguna->delete();
        } else {
            $karyawan->delete();
        }

        LogHelper::catat('pecat_staf', $karyawan->nama_lengkap, "Menghapus data personil dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Data personil telah dihapus permanen.']);
    }

    #[Title('Direktori Personil - Teqara Admin')]
    public function render()
    {
        $query = Karyawan::with(['pengguna', 'jabatan.departemen'])
            ->where('nama_lengkap', 'like', '%'.$this->cari.'%')
            ->orWhere('nip', 'like', '%'.$this->cari.'%')
            ->latest('dibuat_pada');

        return view('livewire.pengelola.manajemen-pegawai.manajemen-karyawan', [
            'karyawan' => $query->paginate(10),
            'daftarJabatan' => \App\Models\Jabatan::with('departemen')->orderBy('nama')->get()
        ])->layout('components.layouts.admin', ['header' => 'Manajemen SDM']);
    }
}