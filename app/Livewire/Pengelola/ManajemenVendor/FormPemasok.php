<?php

namespace App\Livewire\Pengelola\ManajemenVendor;

use App\Helpers\LogHelper;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class FormPemasok
 * Tujuan: Formulir registrasi dan pembaruan data vendor.
 */
class FormPemasok extends Component
{
    public $pemasokId;
    public $kode_pemasok;
    public $nama_perusahaan;
    public $penanggung_jawab;
    public $telepon;
    public $email;
    public $alamat;
    public $status = 'aktif';

    public function mount($id = null)
    {
        if ($id) {
            $p = Pemasok::findOrFail($id);
            $this->pemasokId = $p->id;
            $this->kode_pemasok = $p->kode_pemasok;
            $this->nama_perusahaan = $p->nama_perusahaan;
            $this->penanggung_jawab = $p->penanggung_jawab;
            $this->telepon = $p->telepon;
            $this->email = $p->email;
            $this->alamat = $p->alamat;
            $this->status = $p->status;
        } else {
            $this->kode_pemasok = 'SUP-'.now()->format('Ymd').'-'.rand(100,999);
        }
    }

    public function simpan()
    {
        $rules = [
            'kode_pemasok' => 'required|unique:pemasok,kode_pemasok'.($this->pemasokId ? ','.$this->pemasokId : ''),
            'nama_perusahaan' => 'required|min:3',
            'penanggung_jawab' => 'required',
            'telepon' => 'required',
            'email' => 'required|email',
        ];

        $this->validate($rules);

        $data = [
            'kode_pemasok' => $this->kode_pemasok,
            'nama_perusahaan' => $this->nama_perusahaan,
            'penanggung_jawab' => $this->penanggung_jawab,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'status' => $this->status,
        ];

        if ($this->pemasokId) {
            Pemasok::find($this->pemasokId)->update($data);
            $aksi = 'update_pemasok';
            $pesan = "Profil vendor {$this->nama_perusahaan} berhasil diperbarui.";
        } else {
            Pemasok::create($data);
            $aksi = 'buat_pemasok';
            $pesan = "Kemitraan baru dengan {$this->nama_perusahaan} telah diaktifkan.";
        }

        LogHelper::catat($aksi, $this->nama_perusahaan, $pesan);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        
        return redirect()->route('pengelola.vendor.daftar');
    }

    #[Title('Editor Vendor - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-vendor.form-pemasok')
            ->layout('components.layouts.admin');
    }
}