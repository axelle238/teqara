<?php

namespace App\Livewire\Pengelola\ManajemenVendor;

use App\Helpers\LogHelper;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarPemasok
 * Tujuan: Direktori mitra pemasok (vendor) untuk rantai pasok teknologi.
 */
class DaftarPemasok extends Component
{
    use WithPagination;

    public $tampilkanForm = false;
    public $pemasokId;
    public $cari = '';

    // Form Input
    public $kode_pemasok;
    public $nama_perusahaan;
    public $penanggung_jawab;
    public $telepon;
    public $email;
    public $alamat;
    public $status = 'aktif';

    public function tambahBaru()
    {
        $this->reset(['pemasokId', 'kode_pemasok', 'nama_perusahaan', 'penanggung_jawab', 'telepon', 'email', 'alamat']);
        $this->kode_pemasok = 'VDR-' . strtoupper(Str::random(5));
        $this->status = 'aktif';
        $this->tampilkanForm = true;
    }

    public function edit($id)
    {
        $p = Pemasok::findOrFail($id);
        $this->pemasokId = $p->id;
        $this->kode_pemasok = $p->kode_pemasok;
        $this->nama_perusahaan = $p->nama_perusahaan;
        $this->penanggung_jawab = $p->penanggung_jawab;
        $this->telepon = $p->telepon;
        $this->email = $p->email;
        $this->alamat = $p->alamat;
        $this->status = $p->status;
        
        $this->tampilkanForm = true;
    }

    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['pemasokId', 'kode_pemasok', 'nama_perusahaan', 'penanggung_jawab', 'telepon', 'email', 'alamat']);
    }

    public function simpan()
    {
        $this->validate([
            'kode_pemasok' => 'required|unique:pemasok,kode_pemasok,' . $this->pemasokId,
            'nama_perusahaan' => 'required|min:3',
            'email' => 'nullable|email',
            'telepon' => 'nullable|numeric',
        ]);

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
            $pesan = 'Data vendor berhasil diperbarui.';
            LogHelper::catat('ubah_pemasok', $this->nama_perusahaan, "Update data mitra vendor: {$this->nama_perusahaan}.");
        } else {
            Pemasok::create($data);
            $pesan = 'Mitra vendor baru berhasil didaftarkan.';
            LogHelper::catat('buat_pemasok', $this->nama_perusahaan, "Registrasi mitra vendor baru: {$this->nama_perusahaan}.");
        }

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->batal();
    }

    public function hapus($id)
    {
        $p = Pemasok::findOrFail($id);
        $nama = $p->nama_perusahaan;
        $p->delete();
        
        LogHelper::catat('hapus_pemasok', $nama, "Data kemitraan vendor '{$nama}' dihapus dari sistem.");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Data vendor berhasil dihapus."]);
    }

    #[Title('Direktori Vendor Enterprise - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-vendor.daftar-pemasok', [
            'daftar_pemasok' => Pemasok::where('nama_perusahaan', 'like', '%'.$this->cari.'%')
                ->orWhere('kode_pemasok', 'like', '%'.$this->cari.'%')
                ->latest('dibuat_pada')
                ->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
