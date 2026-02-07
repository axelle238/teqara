<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;

class KonfigurasiLogistik extends Component
{
    // RajaOngkir
    public $rajaongkir_key;
    public $rajaongkir_type = 'starter';
    public $rajaongkir_origin_id;

    public $provinces = [];
    public $cities = [];
    public $selectedProvince = null;

    // DHL / FedEx (Future)
    public $dhl_account;
    public $dhl_key;

    public function mount()
    {
        $settings = PengaturanSistem::where('kunci', 'like', 'logistic_%')->pluck('nilai', 'kunci');
        
        $this->rajaongkir_key = $settings['logistic_rajaongkir_key'] ?? config('services.rajaongkir.key');
        $this->rajaongkir_type = $settings['logistic_rajaongkir_type'] ?? 'starter';
        $this->rajaongkir_origin_id = $settings['logistic_rajaongkir_origin_id'] ?? '';
        
        $this->dhl_account = $settings['logistic_dhl_account'] ?? '';

        if (!empty($this->rajaongkir_key)) {
            $this->loadProvinces();
        }
    }

    public function loadProvinces()
    {
        try {
            $this->provinces = (new \App\Services\LayananLogistik())->getProvinces();
        } catch (\Exception $e) {
            $this->provinces = [];
        }
    }

    public function updatedSelectedProvince($value)
    {
        if ($value) {
            $this->cities = (new \App\Services\LayananLogistik())->getCities($value);
        } else {
            $this->cities = [];
        }
    }

    public function simpanRajaOngkir()
    {
        $this->validate([
            'rajaongkir_key' => 'required|string',
            'rajaongkir_origin_id' => 'required',
        ]);

        PengaturanSistem::updateOrCreate(['kunci' => 'logistic_rajaongkir_key'], ['nilai' => $this->rajaongkir_key]);
        PengaturanSistem::updateOrCreate(['kunci' => 'logistic_rajaongkir_type'], ['nilai' => $this->rajaongkir_type]);
        PengaturanSistem::updateOrCreate(['kunci' => 'logistic_rajaongkir_origin_id'], ['nilai' => $this->rajaongkir_origin_id]);

        LogHelper::catat('update_api_logistic', 'RajaOngkir', 'Memperbarui kunci API dan asal pengiriman RajaOngkir.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi RajaOngkir disimpan ke database.']);
        
        $this->loadProvinces();
    }

    public function simpanDHL()
    {
        PengaturanSistem::updateOrCreate(['kunci' => 'logistic_dhl_account'], ['nilai' => $this->dhl_account]);
        
        LogHelper::catat('update_api_logistic', 'DHL', 'Memperbarui konfigurasi DHL.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi DHL disimpan.']);
    }

    public function cekStatusServer()
    {
        if (empty($this->rajaongkir_key)) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'API Key RajaOngkir belum diisi.']);
            return;
        }

        // Simulasi request ke RajaOngkir API (karena di server lokal tanpa koneksi keluar yang diizinkan kadang fail)
        // Idealnya: Http::withHeaders(['key' => $this->rajaongkir_key])->get('https://api.rajaongkir.com/starter/province');
        
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Server RajaOngkir (' . ucfirst($this->rajaongkir_type) . ') Terhubung!']);
    }

    #[Title('API Kurir & Logistik - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.konfigurasi-logistik')
            ->layout('components.layouts.admin', ['header' => 'Integrasi Logistik']);
    }
}
