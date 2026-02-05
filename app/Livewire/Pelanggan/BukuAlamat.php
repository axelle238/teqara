<?php

namespace App\Livewire\Pelanggan;

use App\Models\AlamatPengiriman;
use Livewire\Attributes\Title;
use Livewire\Component;

class BukuAlamat extends Component
{
    public $alamatId;

    public $label_alamat;

    public $penerima;

    public $telepon;

    public $alamat_lengkap;

    public $kota;

    public $kode_pos;

    public $modeEdit = false;

    protected $rules = [
        'label_alamat' => 'required',
        'penerima' => 'required',
        'telepon' => 'required|numeric',
        'alamat_lengkap' => 'required',
        'kota' => 'required',
        'kode_pos' => 'required|numeric',
    ];

    public function tambahAlamat()
    {
        $this->resetForm();
        $this->dispatch('open-slide-over', id: 'form-alamat');
    }

    public function edit($id)
    {
        $alamat = AlamatPengiriman::where('pengguna_id', auth()->id())->findOrFail($id);
        $this->alamatId = $id;
        $this->label_alamat = $alamat->label_alamat;
        $this->penerima = $alamat->penerima;
        $this->telepon = $alamat->telepon;
        $this->alamat_lengkap = $alamat->alamat_lengkap;
        $this->kota = $alamat->kota;
        $this->kode_pos = $alamat->kode_pos;

        $this->modeEdit = true;
        $this->dispatch('open-slide-over', id: 'form-alamat');
    }

    public function simpan()
    {
        $this->validate();

        $data = [
            'pengguna_id' => auth()->id(),
            'label_alamat' => $this->label_alamat,
            'penerima' => $this->penerima,
            'telepon' => $this->telepon,
            'alamat_lengkap' => $this->alamat_lengkap,
            'kota' => $this->kota,
            'kode_pos' => $this->kode_pos,
        ];

        if ($this->modeEdit) {
            AlamatPengiriman::where('pengguna_id', auth()->id())->where('id', $this->alamatId)->update($data);
            $msg = 'Alamat diperbarui.';
        } else {
            // Jika ini alamat pertama, set jadi utama
            $count = AlamatPengiriman::where('pengguna_id', auth()->id())->count();
            $data['is_utama'] = $count === 0;

            AlamatPengiriman::create($data);
            $msg = 'Alamat baru ditambahkan.';
        }

        $this->dispatch('close-slide-over', id: 'form-alamat');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $msg]);
    }

    public function setUtama($id)
    {
        AlamatPengiriman::where('pengguna_id', auth()->id())->update(['is_utama' => false]);
        AlamatPengiriman::where('pengguna_id', auth()->id())->where('id', $id)->update(['is_utama' => true]);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Alamat utama diubah.']);
    }

    public function hapus($id)
    {
        AlamatPengiriman::where('pengguna_id', auth()->id())->where('id', $id)->delete();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Alamat dihapus.']);
    }

    private function resetForm()
    {
        $this->reset(['alamatId', 'label_alamat', 'penerima', 'telepon', 'alamat_lengkap', 'kota', 'kode_pos', 'modeEdit']);
    }

    #[Title('Buku Alamat - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.buku-alamat', [
            'daftarAlamat' => AlamatPengiriman::where('pengguna_id', auth()->id())->orderBy('is_utama', 'desc')->get(),
        ])->layout('components.layouts.app');
    }
}
