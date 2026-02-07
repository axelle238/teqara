<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Gudang;

use App\Helpers\LogHelper;
use App\Models\Gudang;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarGudang
 * Tujuan: Manajemen Lokasi Inventaris (Multi-Warehouse).
 * Arsitektur: Full Page SPA.
 */
class DaftarGudang extends Component
{
    use WithPagination;

    // State Halaman
    public $tampilkanForm = false;

    // Form
    public $gudangId;
    public $nama;
    public $kode_gudang;
    public $alamat;
    public $kota;
    public $provinsi;
    public $kodepos;
    public $aktif = true;

    // Filter
    public $cari = '';

    public function tambahBaru()
    {
        $this->reset(['gudangId', 'nama', 'kode_gudang', 'alamat', 'kota', 'provinsi', 'kodepos', 'aktif']);
        $this->tampilkanForm = true;
    }

    public function edit($id)
    {
        $g = Gudang::findOrFail($id);
        $this->gudangId = $g->id;
        $this->nama = $g->nama;
        $this->kode_gudang = $g->kode_gudang;
        $this->alamat = $g->alamat;
        $this->kota = $g->kota;
        $this->provinsi = $g->provinsi;
        $this->kodepos = $g->kodepos;
        $this->aktif = $g->aktif;
        
        $this->tampilkanForm = true;
    }

    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['gudangId']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'kode_gudang' => 'required|unique:gudang,kode_gudang,'.$this->gudangId,
            'alamat' => 'required',
        ]);

        $data = [
            'nama' => $this->nama,
            'kode_gudang' => strtoupper($this->kode_gudang),
            'alamat' => $this->alamat,
            'kota' => $this->kota,
            'provinsi' => $this->provinsi,
            'kodepos' => $this->kodepos,
            'aktif' => $this->aktif,
        ];

        if ($this->gudangId) {
            Gudang::find($this->gudangId)->update($data);
            $aksi = 'update_gudang';
            $pesan = "Data gudang {$this->nama} diperbarui.";
        } else {
            Gudang::create($data);
            $aksi = 'buat_gudang';
            $pesan = "Gudang baru {$this->nama} ditambahkan.";
        }

        LogHelper::catat($aksi, $this->kode_gudang, $pesan);
        $this->tampilkanForm = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
    }

    public function toggleStatus($id)
    {
        $g = Gudang::findOrFail($id);
        $g->update(['aktif' => !$g->aktif]);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Status gudang diubah.']);
    }

    #[Title('Manajemen Gudang - Teqara Admin')]
    public function render()
    {
        $gudang = Gudang::withCount('stokGudang')
            ->where('nama', 'like', '%'.$this->cari.'%')
            ->orWhere('kode_gudang', 'like', '%'.$this->cari.'%')
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.gudang.daftar-gudang', [
            'daftarGudang' => $gudang
        ])->layout('components.layouts.admin');
    }
}
