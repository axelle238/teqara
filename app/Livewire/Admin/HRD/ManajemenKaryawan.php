<?php

namespace App\Livewire\Admin\HRD;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenKaryawan extends Component
{
    use WithPagination;

    public $cari = '';

    #[Title('Manajemen SDM - Teqara')]
    public function render()
    {
        $karyawan = DB::table('karyawan')
            ->join('pengguna', 'karyawan.pengguna_id', '=', 'pengguna.id')
            ->join('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->join('departemen', 'jabatan.departemen_id', '=', 'departemen.id')
            ->select('karyawan.*', 'pengguna.nama', 'pengguna.email', 'pengguna.foto_profil', 'jabatan.nama as jabatan', 'departemen.nama as departemen')
            ->where('pengguna.nama', 'like', '%'.$this->cari.'%')
            ->paginate(12);

        return view('livewire.admin.h-r-d.manajemen-karyawan', [
            'karyawan' => $karyawan,
        ])->layout('components.layouts.admin');
    }
}
