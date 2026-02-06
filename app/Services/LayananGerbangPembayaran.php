<?php

namespace App\Services;

use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\TransaksiPembayaran;
use Illuminate\Support\Str;

/**
 * Class LayananGerbangPembayaran
 * Tujuan: Integrasi dan pemrosesan pembayaran via gerbang pembayaran (Gateway) digital.
 */
class LayananGerbangPembayaran
{
    /**
     * Membuat record transaksi baru untuk inisialisasi pembayaran.
     */
    public function buatTransaksi(Pesanan $pesanan, $metode, $provider)
    {
        // Simulasi Permintaan ke API Gerbang Pembayaran
        $kodePembayaran = '';
        if ($metode == 'bank_transfer') {
            $kodePembayaran = '8800'.rand(1000000000, 9999999999); // Simulasi Nomor VA
        } elseif ($metode == 'qris') {
            $kodePembayaran = Str::uuid(); // ID QRIS Digital
        }

        $transaksi = TransaksiPembayaran::create([
            'pesanan_id' => $pesanan->id,
            'kode_pembayaran' => $kodePembayaran,
            'metode_pembayaran' => $metode,
            'provider' => $provider,
            'jumlah_bayar' => $pesanan->total_harga,
            'status' => 'menunggu',
            'muatan_gerbang' => ['mock' => true, 'deskripsi' => 'Simulasi Gateway Teqara'],
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
