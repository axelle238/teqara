<?php

namespace App\Livewire\Admin\ManajemenProduk\Pemasok;

use App\Helpers\LogHelper;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;

class FormPemasok extends Component
{
    public $pemasokId;
    public $kode_pemasok, $nama_perusahaan, $penanggung_jawab, $telepon, $email, $website, $npwp, $alamat, $catatan, $status = 'aktif';

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
            $this->website = $p->website;
            $this->npwp = $p->npwp;
            $this->alamat = $p->alamat;
            $this->catatan = $p->catatan;
            $this->status = $p->status;
        } else {
            $this->kode_pemasok = 'SUP-'.date('Y').'-'.strtoupper(bin2hex(random_bytes(2)));
        }
    }

    public function simpan()
    {
        $this->validate([
            'nama_perusahaan' => 'required|min:3',
            'kode_pemasok' => 'required|unique:pemasok,kode_pemasok,'.$this->pemasokId,
            'email' => 'nullable|email',
            'telepon' => 'required',
        ]);

        $data = [
            'kode_pemasok' => $this->kode_pemasok,
            'nama_perusahaan' => $this->nama_perusahaan,
            'penanggung_jawab' => $this->penanggung_jawab,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'website' => $this->website,
            'npwp' => $this->npwp,
            'alamat' => $this->alamat,
            'catatan' => $this->catatan,
            'status' => $this->status,
        ];

        if ($this->pemasokId) {
            Pemasok::find($this->pemasokId)->update($data);
            $aksi = 'update_pemasok';
            $pesan = "Data vendor {$this->nama_perusahaan} diperbarui.";
        } else {
            Pemasok::create($data);
            $aksi = 'buat_pemasok';
            $pesan = "Vendor baru {$this->nama_perusahaan} berhasil didaftarkan.";
        }

        LogHelper::catat($aksi, $this->nama_perusahaan, $pesan);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        return redirect()->route('admin.logistik.pemasok');
    }

    #[Title('Formulir Vendor - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-produk.pemasok.form-pemasok')
            ->layout('components.layouts.admin');
    }
}
