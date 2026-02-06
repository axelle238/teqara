<?php

namespace App\Livewire\Admin\ManajemenLogistik;

use App\Helpers\LogHelper;
use App\Models\Pemasok;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenPemasok
 * Tujuan: Pengelolaan mitra pemasok (vendor) untuk rantai pasok teknologi.
 */
class ManajemenPemasok extends Component
{
    use WithPagination;

    public $pemasok_id;

    public $kode_pemasok;

    public $nama_perusahaan;

    public $penanggung_jawab;

    public $telepon;

    public $email;

    public $alamat;

    public $status = 'aktif';

    public $cari = '';

    protected $rules = [
        'kode_pemasok' => 'required|unique:pemasok,kode_pemasok',
        'nama_perusahaan' => 'required',
        'penanggung_jawab' => 'required',
        'telepon' => 'required',
        'email' => 'required|email',
    ];

    public function tambahBaru()
    {
        $this->reset(['pemasok_id', 'kode_pemasok', 'nama_perusahaan', 'penanggung_jawab', 'telepon', 'email', 'alamat', 'status']);
        $this->dispatch('open-panel-form-pemasok');
    }

    public function simpan()
    {
        if ($this->pemasok_id) {
            $this->validate([
                'kode_pemasok' => 'required|unique:pemasok,kode_pemasok,'.$this->pemasok_id,
                'nama_perusahaan' => 'required',
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
            $pesan = "Data pemasok {$this->nama_perusahaan} diperbarui.";
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
            $pesan = "Pemasok baru {$this->nama_perusahaan} ditambahkan.";
        }

        LogHelper::catat($aksi, $this->nama_perusahaan, $pesan);
        $this->dispatch('close-panel-form-pemasok');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

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
        $this->dispatch('open-panel-form-pemasok');
    }

    #[Title('Manajemen Pemasok - Admin Teqara')]
    public function render()
    {
        return view('livewire.admin.manajemen-logistik.manajemen-pemasok', [
            'daftar_pemasok' => Pemasok::where('nama_perusahaan', 'like', '%'.$this->cari.'%')->paginate(10),
        ])->layout('components.layouts.admin');
    }
}
