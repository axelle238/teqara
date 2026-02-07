<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Services\LayananIntegrasi;
use Livewire\Attributes\Title;
use Livewire\Component;

class KonfigurasiPembayaran extends Component
{
    public $midtrans_server_key;
    public $midtrans_client_key;
    public $midtrans_is_production = false;
    public $channels = [];

    public function mount(LayananIntegrasi $layanan)
    {
        $config = $layanan->ambilKonfigurasi('pembayaran');
        
        $this->midtrans_server_key = $config['api_pembayaran_midtrans_server_key'] ?? '';
        $this->midtrans_client_key = $config['api_pembayaran_midtrans_client_key'] ?? '';
        $this->midtrans_is_production = filter_var($config['api_pembayaran_midtrans_production'] ?? false, FILTER_VALIDATE_BOOLEAN);
        
        // Channel Aktif (Disimpan sebagai JSON string)
        $this->channels = json_decode($config['api_pembayaran_channels'] ?? '[]', true) ?: [
            'gopay' => true, 'shopeepay' => true, 'bca_va' => true, 'bni_va' => true, 'bri_va' => true, 'qris' => true
        ];
    }

    public function simpan(LayananIntegrasi $layanan)
    {
        $this->validate([
            'midtrans_server_key' => 'required',
            'midtrans_client_key' => 'required',
        ]);

        $layanan->simpanKonfigurasi([
            'api_pembayaran_midtrans_server_key' => $this->midtrans_server_key,
            'api_pembayaran_midtrans_client_key' => $this->midtrans_client_key,
            'api_pembayaran_midtrans_production' => $this->midtrans_is_production,
            'api_pembayaran_channels' => json_encode($this->channels),
        ], 'pembayaran');

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi pembayaran berhasil diperbarui.']);
    }

    public function toggleChannel($key)
    {
        $this->channels[$key] = !($this->channels[$key] ?? false);
    }

    #[Title('Konfigurasi Pembayaran - API Gateway')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.konfigurasi-pembayaran')
            ->layout('components.layouts.admin', ['header' => 'Payment Gateway']);
    }
}