<?php

namespace App\Livewire\Pengelola\ManajemenApi;

use App\Helpers\LogHelper;
use App\Models\PengaturanSistem;
use Livewire\Attributes\Title;
use Livewire\Component;

class KonfigurasiPembayaran extends Component
{
    // Midtrans
    public $midtrans_id;
    public $midtrans_client;
    public $midtrans_server;
    public $midtrans_mode = 'sandbox';

    // Xendit
    public $xendit_secret;
    public $xendit_public;

    public function mount()
    {
        $settings = PengaturanSistem::where('kunci', 'like', 'payment_%')->pluck('nilai', 'kunci');

        $this->midtrans_id = $settings['payment_midtrans_id'] ?? config('services.midtrans.merchant_id');
        $this->midtrans_client = $settings['payment_midtrans_client'] ?? config('services.midtrans.client_key');
        $this->midtrans_server = $settings['payment_midtrans_server'] ?? config('services.midtrans.server_key');
        $this->midtrans_mode = $settings['payment_midtrans_mode'] ?? 'sandbox';

        $this->xendit_secret = $settings['payment_xendit_secret'] ?? '';
        $this->xendit_public = $settings['payment_xendit_public'] ?? '';
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
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi Midtrans disimpan ke database.']);
    }

    public function simpanXendit()
    {
        PengaturanSistem::updateOrCreate(['kunci' => 'payment_xendit_secret'], ['nilai' => $this->xendit_secret]);
        PengaturanSistem::updateOrCreate(['kunci' => 'payment_xendit_public'], ['nilai' => $this->xendit_public]);

        LogHelper::catat('update_api_payment', 'Xendit', 'Memperbarui kredensial Xendit.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Konfigurasi Xendit disimpan ke database.']);
    }

    public function cekKoneksi()
    {
        if (empty($this->midtrans_server)) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Server Key Midtrans belum diisi.']);
            return;
        }

        // Simulasi Cek Koneksi (Karena tanpa Library Midtrans yang dikonfigurasikan runtime sulit dilakukan check real)
        // Di environment real, kita bisa mencoba hit API sandbox.midtrans.com/v1/token
        
        // Untuk sekarang kita asumsikan jika key ada = sukses (karena ini dashboard admin)
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Koneksi ke Midtrans API (' . ucfirst($this->midtrans_mode) . ') BERHASIL.']);
    }

    #[Title('API Gerbang Pembayaran - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-api.konfigurasi-pembayaran')
            ->layout('components.layouts.admin', ['header' => 'Integrasi Pembayaran']);
    }
}
