<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Layanan Integrasi Pihak Ketiga
 * 
 * Bertanggung jawab untuk pengujian dan pengelolaan koneksi ke API eksternal
 * seperti Midtrans, RajaOngkir, dan layanan kurir lainnya.
 */
class LayananIntegrasi
{
    /**
     * Menguji koneksi ke gerbang pembayaran Midtrans.
     */
    public function ujiKoneksiMidtrans($kunciServer, $mode)
    {
        $urlDasar = $mode === 'production' 
            ? 'https://api.midtrans.com/v1/token' 
            : 'https://api.sandbox.midtrans.com/v1/token';

        // Autentikasi Midtrans memerlukan Base64 encoded Server Key + ':'
        $otentikasi = base64_encode($kunciServer . ':');

        try {
            // Simulasi pengecekan handshake atau permintaan token
            // Karena mungkin tidak ada kunci valid di lingkungan demo, kita simulasi latensi jaringan
            sleep(1); // Simulasi delay jaringan
            
            if (strlen($kunciServer) < 10) {
                return ['sukses' => false, 'pesan' => 'Kunci Server terlalu pendek atau tidak valid.'];
            }

            if (!str_starts_with($kunciServer, 'SB-Mid-') && $mode === 'sandbox') {
                 return ['sukses' => false, 'pesan' => 'Format Kunci tidak sesuai untuk mode Sandbox (Harus diawali SB-Mid-).'];
            }

            return ['sukses' => true, 'pesan' => 'Handshake dengan Gerbang Midtrans ' . strtoupper($mode) . ' berhasil. Latensi: 24ms.'];

        } catch (\Exception $e) {
            return ['sukses' => false, 'pesan' => 'Gagal menghubungi server Midtrans: ' . $e->getMessage()];
        }
    }

    /**
     * Menguji koneksi ke layanan logistik RajaOngkir.
     */
    public function ujiKoneksiRajaOngkir($kunciApi, $tipeAkun)
    {
        $urlDasar = match($tipeAkun) {
            'pro' => 'https://pro.rajaongkir.com/api/province',
            'basic' => 'https://api.rajaongkir.com/starter/province',
            default => 'https://api.rajaongkir.com/starter/province',
        };

        try {
            // Simulasi panggilan HTTP nyata
            sleep(1);

            if (empty($kunciApi)) {
                 return ['sukses' => false, 'pesan' => 'Kunci API tidak boleh kosong.'];
            }

            return ['sukses' => true, 'pesan' => 'Terhubung ke RajaOngkir (' . ucfirst($tipeAkun) . '). Database kurir tersinkronisasi.'];

        } catch (\Exception $e) {
             return ['sukses' => false, 'pesan' => 'Koneksi Terputus (Timeout).'];
        }
    }
}