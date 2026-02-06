<?php

namespace App\Livewire\Admin\ManajemenPegawai;

use App\Helpers\LogHelper;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenKaryawan extends Component
{
    use WithPagination;

    // Form Properties
    public $karyawan_id;
    public $nama_lengkap;
    public $nip;
    public $email;
    public $telepon;
    public $jabatan_id;
    public $tanggal_bergabung;
    public $status = 'aktif';
    public $alamat;
    
    // User Account Linking
    public $buat_akun_pengguna = false;
    public $password_default = 'Teqara123';

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

    public function tambahBaru()
    {
        $this->reset(['karyawan_id', 'nama_lengkap', 'nip', 'email', 'telepon', 'jabatan_id', 'tanggal_bergabung', 'status', 'alamat', 'buat_akun_pengguna']);
        $this->tanggal_bergabung = now()->format('Y-m-d');
        $this->dispatch('open-panel-form-karyawan');
    }

    public function edit($id)
    {
        $k = Karyawan::findOrFail($id);
        $this->karyawan_id = $k->id;
        $this->nama_lengkap = $k->nama_lengkap;
        $this->nip = $k->nip;
        $this->email = $k->email;
        $this->telepon = $k->telepon;
        $this->jabatan_id = $k->jabatan_id;
        $this->tanggal_bergabung = $k->tanggal_bergabung->format('Y-m-d');
        $this->status = $k->status;
        $this->alamat = $k->alamat;
        
        $this->dispatch('open-panel-form-karyawan');
    }

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
            $pesan = "Data karyawan {$this->nama_lengkap} diperbarui.";
            $aksi = 'update_karyawan';
        } else {
            $karyawan = Karyawan::create($data);
            $pesan = "Karyawan baru {$this->nama_lengkap} didaftarkan.";
            $aksi = 'buat_karyawan';

            if ($this->buat_akun_pengguna) {
                $user = Pengguna::create([
                    'nama' => $this->nama_lengkap,
                    'email' => $this->email,
                    'password' => bcrypt($this->password_default),
                    'peran' => 'admin', // Default role, should be refined based on Jabatan
                    'email_verified_at' => now(),
                ]);
                $karyawan->update(['pengguna_id' => $user->id]);
                $pesan .= " Akun sistem dibuat.";
            }
        }

        LogHelper::catat($aksi, $this->nip, $pesan);
        $this->dispatch('close-panel-form-karyawan');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    #[Title('Direktori Pegawai - Admin Teqara')]
    public function render()
    {
        $karyawan = Karyawan::with(['jabatan.departemen'])
            ->where('nama_lengkap', 'like', '%'.$this->cari.'%')
            ->when($this->filter_departemen, function($q) {
                $q->whereHas('jabatan', fn($j) => $j->where('departemen_id', $this->filter_departemen));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manajemen-pegawai.manajemen-karyawan', [
            'karyawan' => $karyawan,
            'departemen' => Departemen::with('jabatan')->get(),
            'jabatan' => Jabatan::all(),
        ])->layout('components.layouts.admin');
    }
}