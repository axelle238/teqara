<?php

namespace App\Services;

use App\Models\LogAktivitas;
use App\Models\PengaturanSistem;
use App\Models\Pesanan;
use App\Models\TransaksiPembayaran;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

/**
 * Class LayananGerbangPembayaran
 * Tujuan: Integrasi dan pemrosesan pembayaran via gerbang pembayaran (Gateway) digital.
 */
class LayananGerbangPembayaran
{
    protected function konfigurasiMidtrans()
    {
        $settings = PengaturanSistem::pluck('nilai', 'kunci');
        
        Config::$serverKey = $settings['payment_midtrans_server'] ?? config('services.midtrans.server_key');
        Config::$isProduction = ($settings['payment_midtrans_mode'] ?? 'sandbox') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Membuat record transaksi baru untuk inisialisasi pembayaran.
     */
    public function buatTransaksi(Pesanan $pesanan, $metode, $provider)
    {
        $kodePembayaran = (string) Str::uuid();
        $muatanGerbang = ['mock' => true, 'deskripsi' => 'Simulasi Gateway Teqara'];
        $snapToken = null;

        // Integrasi Midtrans
        if ($provider == 'midtrans') {
            $this->konfigurasiMidtrans();

            // Item Details
            $items = [];
            foreach ($pesanan->detailPesanan as $detail) {
                $items[] = [
                    'id' => $detail->produk_id,
                    'price' => (int) $detail->harga_saat_ini,
                    'quantity' => $detail->jumlah,
                    'name' => substr($detail->produk->nama, 0, 50),
                ];
            }

            // Tambah Ongkir
            if ($pesanan->biaya_pengiriman > 0) {
                $items[] = [
                    'id' => 'SHIPPING',
                    'price' => (int) $pesanan->biaya_pengiriman,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman',
                ];
            }

            // Potongan (Diskon) - Midtrans tidak support item negatif langsung, 
            // jadi kita sesuaikan total atau kirim total_harga langsung sebagai gross_amount
            // Untuk keamanan dan simplisitas, kita gunakan gross_amount saja jika ada diskon kompleks
            
            $orderId = $pesanan->nomor_faktur . '-' . rand(100,999); // Unik setiap attempt

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $pesanan->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $pesanan->pengguna->nama,
                    'email' => $pesanan->pengguna->email,
                    'phone' => $pesanan->pengguna->nomor_telepon,
                ],
                // 'item_details' => $items, // Opsional: aktifkan jika total hitungan item == gross_amount
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $kodePembayaran = $orderId; // Simpan Order ID Midtrans, bukan UUID
                $baseUrl = Config::$isProduction ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com';
                $muatanGerbang = ['token' => $snapToken, 'redirect_url' => "$baseUrl/snap/v2/vtweb/$snapToken"];
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Midtrans Error: ' . $e->getMessage());
                // Fallback ke manual jika API error
                $provider = 'manual'; 
            }
        } 
        
        // Logika Fallback / Manual
        if ($metode == 'bank_transfer' || $metode == 'manual') {
            $kodePembayaran = '8800'.rand(1000000000, 9999999999);
        } elseif ($metode == 'qris' && $provider != 'midtrans') {
            $kodePembayaran = Str::uuid();
        }

        $transaksi = TransaksiPembayaran::create([
            'pesanan_id' => $pesanan->id,
            'kode_pembayaran' => $kodePembayaran,
            'metode_pembayaran' => $metode,
            'provider' => $provider,
            'jumlah_bayar' => $pesanan->total_harga,
            'status' => 'menunggu',
            'payload_gateway' => $muatanGerbang,
        ]);

        return $transaksi;
    }

    /**
     * Memproses notifikasi status pembayaran dari penyedia gateway.
     */
    public function prosesNotifikasi($transaksiId, $status)
    {
        $transaksi = TransaksiPembayaran::findOrFail($transaksiId);
        $pesanan = $transaksi->pesanan;

        if ($status == 'sukses') {
            $transaksi->update([
                'status' => 'sukses',
                'waktu_bayar' => now(),
            ]);

            $pesanan->update([
                'status_pembayaran' => 'lunas',
                'status_pesanan' => 'diproses',
            ]);

            // Finalisasi Inventaris
            (new LayananStok)->finalisasiStok($pesanan);

            // Akumulasi Poin Loyalitas
            $poinDapat = floor($pesanan->total_harga / 10000);
            if ($poinDapat > 0 && $pesanan->pengguna) {
                (new LayananGamifikasi)->tambahPoin($pesanan->pengguna, $poinDapat, 'pembelian', $pesanan->nomor_faktur);
            }

            LogAktivitas::create([
                'pengguna_id' => $pesanan->pengguna_id,
                'aksi' => 'pembayaran_sukses',
                'target' => $pesanan->nomor_faktur,
                'pesan_naratif' => "Otoritas pembayaran faktur #{$pesanan->nomor_faktur} berhasil diverifikasi via {$transaksi->provider}.",
                'waktu' => now(),
            ]);
        } else {
            $transaksi->update(['status' => 'gagal']);
            $pesanan->update(['status_pembayaran' => 'gagal']);
        }
    }
}
