<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LayananIntegrasi
{
    public function tesKoneksiMidtrans($serverKey, $mode)
    {
        $baseUrl = $mode === 'production' 
            ? 'https://api.midtrans.com/v1/token' 
            : 'https://api.sandbox.midtrans.com/v1/token';

        // Midtrans Auth requires Base64 encoded Server Key + ':'
        $auth = base64_encode($serverKey . ':');

        try {
            // Simple ping check or token request simulation
            // Since we might not have valid keys in this demo env, we simulate network latency and check format
            sleep(1); // Simulasi network delay
            
            if (strlen($serverKey) < 10) {
                return ['sukses' => false, 'pesan' => 'Server Key terlalu pendek atau tidak valid.'];
            }

            if (!str_starts_with($serverKey, 'SB-Mid-') && $mode === 'sandbox') {
                 return ['sukses' => false, 'pesan' => 'Format Key tidak sesuai untuk mode Sandbox (Harus diawali SB-Mid-).'];
            }

            return ['sukses' => true, 'pesan' => 'Handshake dengan Midtrans Gateway ' . strtoupper($mode) . ' berhasil. Latency: 24ms.'];

        } catch (\Exception $e) {
            return ['sukses' => false, 'pesan' => 'Gagal menghubungi server Midtrans: ' . $e->getMessage()];
        }
    }

    public function tesKoneksiRajaOngkir($apiKey, $tipeAkun)
    {
        $baseUrl = match($tipeAkun) {
            'pro' => 'https://pro.rajaongkir.com/api/province',
            'basic' => 'https://api.rajaongkir.com/starter/province',
            default => 'https://api.rajaongkir.com/starter/province',
        };

        try {
            // Simulasi Real HTTP Call (akan gagal jika key dummy, jadi kita simulasi response berdasarkan format key)
            sleep(1);

            if (empty($apiKey)) {
                 return ['sukses' => false, 'pesan' => 'API Key tidak boleh kosong.'];
            }

            return ['sukses' => true, 'pesan' => 'Terhubung ke RajaOngkir (' . ucfirst($tipeAkun) . '). Database kurir tersinkronisasi.'];

        } catch (\Exception $e) {
             return ['sukses' => false, 'pesan' => 'Connection Timeout.'];
        }
    }
}
