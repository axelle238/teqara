<?php

namespace App\Livewire\Admin\HRD;

use App\Helpers\LogHelper;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenKaryawan extends Component
{
    use WithPagination;

    public $karyawan_id;

    public $pengguna_id;

    public $jabatan_id;

    public $nip;

    public $tanggal_bergabung;

    public $status_kerja;

    public $cari = '';

    public function tambahBaru()
    {
        $this->reset(['karyawan_id', 'pengguna_id', 'jabatan_id', 'nip', 'tanggal_bergabung', 'status_kerja']);
        $this->dispatch('open-slide-over', id: 'form-karyawan');
    }

    public function simpan()
    {
        $this->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'nip' => 'required|unique:karyawan,nip,'.$this->karyawan_id,
            'tanggal_bergabung' => 'required|date',
            'status_kerja' => 'required',
        ]);

        $data = [
            'pengguna_id' => $this->pengguna_id,
            'jabatan_id' => $this->jabatan_id,
            'nip' => $this->nip,
            'tanggal_bergabung' => $this->tanggal_bergabung,
            'status_kerja' => $this->status_kerja,
        ];

        if ($this->karyawan_id) {
            $k = Karyawan::find($this->karyawan_id);
            $k->update($data);
            $aksi = 'update_karyawan';
            $pesan = "Data karyawan NIP {$this->nip} diperbarui.";
        } else {
            Karyawan::create($data);
            $aksi = 'create_karyawan';
            $pesan = "Karyawan baru NIP {$this->nip} didaftarkan.";
        }

        LogHelper::catat($aksi, $this->nip, $pesan);
        $this->dispatch('close-slide-over', id: 'form-karyawan');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    #[Title('Manajemen SDM - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.h-r-d.manajemen-karyawan', [
            'karyawan' => Karyawan::with(['pengguna', 'jabatan.departemen'])
                ->where('nip', 'like', '%'.$this->cari.'%')
                ->paginate(10),
            'list_pengguna' => Pengguna::whereDoesntHave('karyawan')->get(), // Hanya user yg belum jadi karyawan
            'list_jabatan' => Jabatan::with('departemen')->get(),
        ])->layout('components.layouts.admin');
    }
}
