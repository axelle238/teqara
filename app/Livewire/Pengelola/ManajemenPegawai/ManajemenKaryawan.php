<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Helpers\LogHelper;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenKaryawan
 * Tujuan: Manajemen profil profesional dan akun staf Teqara.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenKaryawan extends Component
{
    use WithPagination;

    // State Antarmuka
    public $tampilkanForm = false;

    // Properti Model
    public $karyawan_id;
    public $nama_lengkap;
    public $nip;
    public $email;
    public $telepon;
    public $jabatan_id;
    public $tanggal_bergabung;
    public $status = 'aktif';
    public $alamat;
    
    // Account Settings
    public $buat_akun_pengguna = false;
    public $password_default = 'Teqara123';

    // Filters
    public $cari = '';
    public $filter_departemen = '';

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|min:3',
            'nip' => 'required|unique:karyawan,nip,'.$this->karyawan_id,
            'email' => 'required|email|unique:karyawan,email,'.$this->karyawan_id,
            'jabatan_id' => 'required|exists:jabatan,id',
            'tanggal_bergabung' => 'required|date',
        ];
    }

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'nip.unique' => 'NIP sudah terdaftar di sistem.',
        'email.email' => 'Format email resmi tidak valid.',
        'jabatan_id.required' => 'Posisi jabatan harus dipilih.',
    ];

    /**
     * Beralih ke mode onboarding staf baru (Halaman Penuh).
     */
    public function tambahBaru()
    {
        $this->reset(['karyawan_id', 'nama_lengkap', 'nip', 'email', 'telepon', 'jabatan_id', 'tanggal_bergabung', 'status', 'alamat', 'buat_akun_pengguna']);
        $this->tanggal_bergabung = now()->format('Y-m-d');
        $this->tampilkanForm = true;
    }

    /**
     * Beralih ke mode sunting profil staf (Halaman Penuh).
     */
    public function edit($id)
    {
        $k = Karyawan::findOrFail($id);
        $this->karyawan_id = $k->id;
        $this->nama_lengkap = $k->nama_lengkap;
        $this->nip = $k->nip;
        $this->email = $k->email;
        $this->telepon = $k->telepon;
        $this->jabatan_id = $k->jabatan_id;
        $this->tanggal_bergabung = $k->tanggal_bergabung instanceof \DateTimeInterface 
            ? $k->tanggal_bergabung->format('Y-m-d') 
            : $k->tanggal_bergabung;
        $this->status = $k->status;
        $this->alamat = $k->alamat;
        
        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan kembali ke direktori staf.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['karyawan_id']);
    }

    /**
     * Menyimpan data karyawan ke database.
     */
    public function simpan()
    {
        $this->validate();

        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'nip' => $this->nip,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'jabatan_id' => $this->jabatan_id,
            'tanggal_bergabung' => $this->tanggal_bergabung,
            'status' => $this->status,
            'alamat' => $this->alamat,
        ];

        if ($this->karyawan_id) {
            $karyawan = Karyawan::find($this->karyawan_id);
            $karyawan->update($data);
            $pesan = "Profil staf {$this->nama_lengkap} berhasil diperbarui.";
            $aksi = 'update_karyawan';
        } else {
            $karyawan = Karyawan::create($data);
            $pesan = "Karyawan baru {$this->nama_lengkap} telah di-onboarding.";
            $aksi = 'buat_karyawan';

            if ($this->buat_akun_pengguna) {
                $user = Pengguna::create([
                    'nama' => $this->nama_lengkap,
                    'email' => $this->email,
                    'kata_sandi' => bcrypt($this->password_default),
                    'peran' => 'admin',
                    'email_diverifikasi_pada' => now(),
                ]);
                $karyawan->update(['pengguna_id' => $user->id]);
                $pesan .= " Akses sistem diaktifkan.";
            }
        }

        LogHelper::catat($aksi, $this->nip, $pesan);
        $this->tampilkanForm = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    #[Title('Direktori Pegawai Enterprise - Teqara')]
    public function render()
    {
        $karyawan = Karyawan::with(['jabatan.departemen'])
            ->when($this->cari, function($q) {
                $q->where(function($sub) {
                    $sub->where('nama_lengkap', 'like', '%'.$this->cari.'%')
                        ->orWhere('nip', 'like', '%'.$this->cari.'%');
                });
            })
            ->when($this->filter_departemen, function($q) {
                $q->whereHas('jabatan', fn($j) => $j->where('departemen_id', $this->filter_departemen));
            })
            ->latest()
            ->paginate(12);

        return view('livewire.pengelola.manajemen-pegawai.manajemen-karyawan', [
            'karyawan' => $karyawan,
            'departemen' => Departemen::with('jabatan')->get(),
            'jabatan' => Jabatan::all(),
        ])->layout('components.layouts.admin');
    }
}
