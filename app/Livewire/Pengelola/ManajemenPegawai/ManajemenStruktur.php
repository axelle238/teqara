<?php

namespace App\Livewire\Pengelola\ManajemenPegawai;

use App\Helpers\LogHelper;
use App\Models\Departemen;
use App\Models\Jabatan;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class ManajemenStruktur
 * Tujuan: Manajemen hirarki organisasi, departemen, dan jabatan struktural.
 */
class ManajemenStruktur extends Component
{
    public $inputNamaDept;

    public $inputKodeDept;

    public $inputNamaJabatan;

    public $inputDeptId;

    public $inputGaji;

    public function simpanDept()
    {
        $this->validate([
            'inputNamaDept' => 'required|min:3',
            'inputKodeDept' => 'required|unique:departemen,kode',
        ]);

        Departemen::create([
            'nama' => $this->inputNamaDept,
            'kode' => $this->inputKodeDept,
        ]);

        LogHelper::catat('buat_departemen', $this->inputNamaDept, "Admin menambah departemen baru: {$this->inputNamaDept}");
        $this->reset(['inputNamaDept', 'inputKodeDept']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Departemen berhasil ditambahkan.']);
    }

    public function simpanJabatan()
    {
        $this->validate([
            'inputNamaJabatan' => 'required',
            'inputDeptId' => 'required|exists:departemen,id',
            'inputGaji' => 'required|numeric',
        ]);

        Jabatan::create([
            'nama' => $this->inputNamaJabatan,
            'departemen_id' => $this->inputDeptId,
            'gaji_pokok' => $this->inputGaji,
        ]);

        LogHelper::catat('buat_jabatan', $this->inputNamaJabatan, "Admin menambah jabatan baru: {$this->inputNamaJabatan}");
        $this->reset(['inputNamaJabatan', 'inputDeptId', 'inputGaji']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Jabatan berhasil ditambahkan.']);
    }

    #[Title('Struktur Organisasi - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-pegawai.manajemen-struktur', [
            'daftar_dept' => Departemen::with('jabatan')->get(),
            'semua_dept' => Departemen::all(),
        ])->layout('components.layouts.admin');
    }
}
