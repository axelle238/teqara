<?php

namespace App\Livewire\Pengelola\ManajemenLogistik;

use App\Helpers\LogHelper;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenPemasok
 * Tujuan: Pengelolaan mitra pemasok (vendor) untuk rantai pasok teknologi.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenPemasok extends Component
{
    use WithPagination;

    // State Halaman
    public $tampilkanForm = false;

    // Properti Model
    public $pemasok_id;
    public $kode_pemasok;
    public $nama_perusahaan;
    public $penanggung_jawab;
    public $telepon;
    public $email;
    public $alamat;
    public $status = 'aktif';

    // Filter
    public $cari = '';

    protected $rules = [
        'kode_pemasok' => 'required|unique:pemasok,kode_pemasok',
        'nama_perusahaan' => 'required|min:3',
        'penanggung_jawab' => 'required',
        'telepon' => 'required',
        'email' => 'required|email',
    ];

    protected $messages = [
        'kode_pemasok.required' => 'Kode vendor unik wajib diisi.',
        'kode_pemasok.unique' => 'Kode vendor ini sudah terdaftar.',
        'nama_perusahaan.required' => 'Nama instansi/perusahaan wajib diisi.',
        'penanggung_jawab.required' => 'Nama PIC wajib diisi.',
        'email.email' => 'Format email resmi tidak valid.',
    ];

    /**
     * Beralih ke mode tambah pemasok (Halaman Penuh).
     */
    public function tambahBaru()
    {
        $this->reset(['pemasok_id', 'kode_pemasok', 'nama_perusahaan', 'penanggung_jawab', 'telepon', 'email', 'alamat', 'status']);
        $this->kode_pemasok = 'SUP-'.now()->format('Ymd').'-'.rand(100,999);
        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan kembali ke direktori vendor.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['pemasok_id']);
    }

    /**
     * Menyimpan data pemasok ke database.
     */
    public function simpan()
    {
        if ($this->pemasok_id) {
            $this->validate([
                'kode_pemasok' => 'required|unique:pemasok,kode_pemasok,'.$this->pemasok_id,
                'nama_perusahaan' => 'required|min:3',
                'penanggung_jawab' => 'required',
                'telepon' => 'required',
                'email' => 'required|email',
            ]);

            $pemasok = Pemasok::find($this->pemasok_id);
            $pemasok->update([
                'kode_pemasok' => $this->kode_pemasok,
                'nama_perusahaan' => $this->nama_perusahaan,
                'penanggung_jawab' => $this->penanggung_jawab,
                'telepon' => $this->telepon,
                'email' => $this->email,
                'alamat' => $this->alamat,
                'status' => $this->status,
            ]);
            $aksi = 'update_pemasok';
            $pesan = "Profil vendor {$this->nama_perusahaan} berhasil diperbarui.";
        } else {
            $this->validate();
            Pemasok::create([
                'kode_pemasok' => $this->kode_pemasok,
                'nama_perusahaan' => $this->nama_perusahaan,
                'penanggung_jawab' => $this->penanggung_jawab,
                'telepon' => $this->telepon,
                'email' => $this->email,
                'alamat' => $this->alamat,
                'status' => $this->status,
            ]);
            $aksi = 'buat_pemasok';
            $pesan = "Kemitraan baru dengan {$this->nama_perusahaan} telah diaktifkan.";
        }

        LogHelper::catat($aksi, $this->nama_perusahaan, $pesan);
        $this->tampilkanForm = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    /**
     * Beralih ke mode edit profil vendor (Halaman Penuh).
     */
    public function edit($id)
    {
        $p = Pemasok::findOrFail($id);
        $this->pemasok_id = $p->id;
        $this->kode_pemasok = $p->kode_pemasok;
        $this->nama_perusahaan = $p->nama_perusahaan;
        $this->penanggung_jawab = $p->penanggung_jawab;
        $this->telepon = $p->telepon;
        $this->email = $p->email;
        $this->alamat = $p->alamat;
        $this->status = $p->status;

        $this->tampilkanForm = true;
    }

    /**
     * Menghapus kemitraan vendor.
     */
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
        return view('livewire.pengelola.manajemen-logistik.manajemen-pemasok', [
            'daftar_pemasok' => Pemasok::where('nama_perusahaan', 'like', '%'.$this->cari.'%')->latest()->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
