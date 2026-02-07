<?php

namespace App\Livewire\Pelanggan;

use App\Models\AlamatPengiriman;
use Livewire\Attributes\Title;
use Livewire\Component;

class BukuAlamat extends Component
{
    public $tambahMode = false;
    public $editMode = false;
    public $alamatId;

    // Form Fields
    public $label_alamat;
    public $penerima;
    public $telepon;
    public $provinsi_id;
    public $kota_id;
    public $kota; // Diisi otomatis dari label kota RajaOngkir
    public $kode_pos;
    public $alamat_lengkap;
    public $is_utama = false;

    // Local Dropdown Data
    public $provinces = [];
    public $cities = [];

    public function mount()
    {
        $this->loadProvinces();
    }

    public function loadProvinces()
    {
        try {
            $this->provinces = (new \App\Services\LayananLogistik())->getProvinces();
        } catch (\Exception $e) {
            $this->provinces = [];
        }
    }

    public function updatedProvinsiId($value)
    {
        if ($value) {
            $this->cities = (new \App\Services\LayananLogistik())->getCities($value);
        } else {
            $this->cities = [];
        }
        $this->kota_id = null;
        $this->kota = '';
    }

    public function updatedKotaId($value)
    {
        if ($value) {
            $selectedCity = collect($this->cities)->firstWhere('city_id', $value);
            if ($selectedCity) {
                $this->kota = $selectedCity['type'] . ' ' . $selectedCity['city_name'];
                $this->kode_pos = $selectedCity['postal_code'];
            }
        }
    }

    public function getDaftarAlamatProperty()
    {
        return AlamatPengiriman::where('pengguna_id', auth()->id())
            ->orderByDesc('is_utama')
            ->orderByDesc('dibuat_pada')
            ->get();
    }

    public function tambahBaru()
    {
        $this->resetForm();
        $this->tambahMode = true;
        $this->editMode = false;
        $this->loadProvinces();
    }

    public function edit($id)
    {
        $alamat = AlamatPengiriman::where('pengguna_id', auth()->id())->findOrFail($id);
        
        $this->alamatId = $alamat->id;
        $this->label_alamat = $alamat->label_alamat;
        $this->penerima = $alamat->penerima;
        $this->telepon = $alamat->telepon;
        $this->provinsi_id = $alamat->provinsi_id;
        $this->kota_id = $alamat->kota_id;
        $this->kota = $alamat->kota;
        $this->kode_pos = $alamat->kode_pos;
        $this->alamat_lengkap = $alamat->alamat_lengkap;
        $this->is_utama = $alamat->is_utama;

        $this->tambahMode = false;
        $this->editMode = true;

        if ($this->provinsi_id) {
            $this->cities = (new \App\Services\LayananLogistik())->getCities($this->provinsi_id);
        }
    }

    public function batal()
    {
        $this->resetForm();
        $this->tambahMode = false;
        $this->editMode = false;
    }

    public function simpan()
    {
        $this->validate([
            'label_alamat' => 'required|string|max:50',
            'penerima' => 'required|string|max:100',
            'telepon' => 'required|numeric|digits_between:10,15',
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
            'alamat_lengkap' => 'required|string|min:10',
        ]);

        $data = [
            'pengguna_id' => auth()->id(),
            'label_alamat' => $this->label_alamat,
            'penerima' => $this->penerima,
            'telepon' => $this->telepon,
            'provinsi_id' => $this->provinsi_id,
            'kota_id' => $this->kota_id,
            'kota' => $this->kota,
            'kode_pos' => $this->kode_pos,
            'alamat_lengkap' => $this->alamat_lengkap,
            'is_utama' => $this->is_utama,
        ];

        if ($this->is_utama) {
            AlamatPengiriman::where('pengguna_id', auth()->id())->update(['is_utama' => false]);
        }

        if ($this->editMode) {
            AlamatPengiriman::where('pengguna_id', auth()->id())
                ->where('id', $this->alamatId)
                ->update($data);
            $pesan = 'Alamat berhasil diperbarui.';
        } else {
            // Jika ini alamat pertama, otomatis jadi utama
            if (AlamatPengiriman::where('pengguna_id', auth()->id())->count() == 0) {
                $data['is_utama'] = true;
            }
            AlamatPengiriman::create($data);
            $pesan = 'Alamat baru berhasil ditambahkan.';
        }

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->batal();
    }

    public function setUtama($id)
    {
        AlamatPengiriman::where('pengguna_id', auth()->id())->update(['is_utama' => false]);
        AlamatPengiriman::where('pengguna_id', auth()->id())->where('id', $id)->update(['is_utama' => true]);
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Alamat utama diperbarui.']);
    }

    public function hapus($id)
    {
        $alamat = AlamatPengiriman::where('pengguna_id', auth()->id())->findOrFail($id);
        
        if ($alamat->is_utama) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Tidak dapat menghapus alamat utama.']);
            return;
        }

        $alamat->delete();
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Alamat dihapus.']);
    }

    private function resetForm()
    {
        $this->reset(['label_alamat', 'penerima', 'telepon', 'kota', 'kode_pos', 'alamat_lengkap', 'is_utama', 'alamatId']);
    }

    #[Title('Buku Alamat - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.buku-alamat')
            ->layout('components.layouts.app');
    }
}
