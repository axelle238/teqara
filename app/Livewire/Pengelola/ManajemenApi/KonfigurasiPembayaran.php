<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use App\Services\LayananIntegrasi;
use Livewire\Attributes\Title;
use Livewire\Component;

class KonfigurasiPembayaran extends Component
{
    // Midtrans
    public $midtrans_id;
    public $midtrans_client;
    public $midtrans_server;
    public $midtrans_mode = 'sandbox';
    public $midtrans_status = false; // Connect status

    // Xendit
    public $xendit_secret;
    public $xendit_public;
    public $xendit_mode = 'development';

    // UI States
    public $testing_midtrans = false;
    public $test_result_midtrans = null;

    public function mount()
    {
        $settings = PengaturanSistem::where('kunci', 'like', 'payment_%')->pluck('nilai', 'kunci');

        $this->midtrans_id = $settings['payment_midtrans_id'] ?? config('services.midtrans.merchant_id');
        $this->midtrans_client = $settings['payment_midtrans_client'] ?? config('services.midtrans.client_key');
        $this->midtrans_server = $settings['payment_midtrans_server'] ?? config('services.midtrans.server_key');
        $this->midtrans_mode = $settings['payment_midtrans_mode'] ?? 'sandbox';
        
        $this->xendit_secret = $settings['payment_xendit_secret'] ?? '';
        $this->xendit_public = $settings['payment_xendit_public'] ?? '';
        $this->xendit_mode = $settings['payment_xendit_mode'] ?? 'development';
    }

    public function simpanMidtrans()
    {
        $this->validate([
            'midtrans_id' => 'required|string',
            'midtrans_client' => 'required|string',
            'midtrans_server' => 'required|string',
        ]);

        PengaturanSistem::updateOrCreate(['kunci' => 'payment_midtrans_id'], ['nilai' => $this->midtrans_id]);
        PengaturanSistem::updateOrCreate(['kunci' => 'payment_midtrans_client'], ['nilai' => $this->midtrans_client]);
        PengaturanSistem::updateOrCreate(['kunci' => 'payment_midtrans_server'], ['nilai' => $this->midtrans_server]);
        PengaturanSistem::updateOrCreate(['kunci' => 'payment_midtrans_mode'], ['nilai' => $this->midtrans_mode]);

        LogHelper::catat('update_api_payment', 'Midtrans', 'Memperbarui kredensial Midtrans.');
        $this->dispatch('notifikasi', tipe: 'sukses', pesan: 'Konfigurasi Midtrans berhasil disimpan & disinkronisasi ke Storefront.');
    }

    public function testMidtrans(LayananIntegrasi $integrasi)
    {
        $this->testing_midtrans = true;
        $this->test_result_midtrans = null;

        $hasil = $integrasi->tesKoneksiMidtrans($this->midtrans_server, $this->midtrans_mode);

        $this->testing_midtrans = false;
        
        if ($hasil['sukses']) {
            $this->test_result_midtrans = ['status' => 'success', 'pesan' => $hasil['pesan']];
            $this->dispatch('notifikasi', tipe: 'sukses', pesan: 'Koneksi Terverifikasi!');
        } else {
            $this->test_result_midtrans = ['status' => 'error', 'pesan' => $hasil['pesan']];
            $this->dispatch('notifikasi', tipe: 'error', pesan: 'Koneksi Gagal: ' . $hasil['pesan']);
        }
    }

    #[Title('API Gerbang Pembayaran - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.konfigurasi-pembayaran')
            ->layout('components.layouts.admin', ['header' => 'Integrasi Pembayaran Enterprise']);
    }
}
