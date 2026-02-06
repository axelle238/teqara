<?php

namespace App\Services;

use App\Models\Pesanan;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * LayananStok Enterprise v16.0
 * Mendukung mutasi antar gudang dan pencatatan nomor seri – 100% Bahasa Indonesia.
 */
class LayananStok
{
    /**
     * Menahan stok saat pesanan dibuat.
     */
    public function tahanStok(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;

                if ($produk->stok < $detail->jumlah) {
                    throw new Exception("Stok fisik tidak mencukupi untuk unit: {$produk->nama}");
                }

                $produk->decrement('stok', $detail->jumlah);
                $produk->increment('stok_ditahan', $detail->jumlah);
            }
        });
    }

    /**
     * Finalisasi stok saat pembayaran lunas.
     */
    public function finalisasiStok(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;

                $produk->decrement('stok_ditahan', $detail->jumlah);

                DB::table('stok_gudang')
                    ->where('produk_id', $produk->id)
                    ->where('gudang_id', 1)
                    ->decrement('jumlah', $detail->jumlah);

                DB::table('mutasi_stok')->insert([
                    'produk_id' => $produk->id,
                    'jumlah' => -$detail->jumlah,
                    'jenis_mutasi' => 'penjualan',
                    'referensi_id' => $pesanan->nomor_faktur,
                    'keterangan' => 'Penjualan Faktur #'.$pesanan->nomor_faktur,
                    'oleh_pengguna_id' => $pesanan->pengguna_id,
                    'dibuat_pada' => now(),
                    'diperbarui_pada' => now(),
                ]);
            }
        });
    }

    /**
     * Memindahkan stok antar gudang.
     */
    public function pindahStok($produkId, $dariGudangId, $keGudangId, $jumlah, $keterangan = '')
    {
        DB::transaction(function () use ($produkId, $dariGudangId, $keGudangId, $jumlah, $keterangan) {
            DB::table('stok_gudang')
                ->where('produk_id', $produkId)
                ->where('gudang_id', $dariGudangId)
                ->decrement('jumlah', $jumlah);

            DB::table('stok_gudang')->updateOrInsert(
                ['produk_id' => $produkId, 'gudang_id' => $keGudangId],
                ['jumlah' => DB::raw("jumlah + $jumlah"), 'diperbarui_pada' => now()]
            );

            DB::table('mutasi_stok')->insert([
                'produk_id' => $produkId,
                'jumlah' => 0,
                'jenis_mutasi' => 'pindah_gudang',
                'keterangan' => "Transfer antar gudang: $keterangan",
                'oleh_pengguna_id' => auth()->id(),
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        });
    }
}
