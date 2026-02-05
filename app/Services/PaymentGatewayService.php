<?php

namespace App\Services;

use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\TransaksiPembayaran;
use App\Services\LayananStok;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    public function buatTransaksi(Pesanan $pesanan, $metode, $provider)
    {
        // Simulasi Request ke API Gateway (Midtrans/Xendit)

        $kodePembayaran = '';
        if ($metode == 'bank_transfer') {
            $kodePembayaran = '8800'.rand(1000000000, 9999999999); // Simulasi VA
        } elseif ($metode == 'qris') {
            $kodePembayaran = Str::uuid(); // ID QRIS
        }

        $transaksi = TransaksiPembayaran::create([
            'pesanan_id' => $pesanan->id,
            'kode_pembayaran' => $kodePembayaran,
            'metode_pembayaran' => $metode,
            'provider' => $provider,
            'jumlah_bayar' => $pesanan->total_harga,
            'status' => 'pending',
            'payload_gateway' => ['mock' => true, 'desc' => 'Simulasi Gateway Teqara'],
        ]);

        return $transaksi;
    }

    public function prosesNotifikasi($transaksiId, $status)
    {
        $transaksi = TransaksiPembayaran::findOrFail($transaksiId);
        $pesanan = $transaksi->pesanan;

        if ($status == 'success') {
            $transaksi->update([
                'status' => 'success',
                'waktu_bayar' => now(),
            ]);

            $pesanan->update([
                'status_pembayaran' => 'lunas',
                'status_pesanan' => 'diproses', // Auto move to processing
            ]);

            // Finalisasi Stok
            (new LayananStok)->finalisasiStok($pesanan);

            LogAktivitas::create([
                'pengguna_id' => $pesanan->pengguna_id,
                'aksi' => 'pembayaran_sukses',
                'target' => $pesanan->nomor_invoice,
                'pesan_naratif' => "Pembayaran untuk pesanan {$pesanan->nomor_invoice} berhasil via {$transaksi->provider}.",
                'waktu' => now(),
            ]);
        } else {
            $transaksi->update(['status' => 'failed']);
            $pesanan->update(['status_pembayaran' => 'gagal']);
        }
    }
}
