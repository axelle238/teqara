<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\Produk;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * LayananStok Enterprise v16.0
 * Mendukung mutasi antar gudang, adjustment, dan pencatatan nomor seri – 100% Bahasa Indonesia.
 */
class LayananStok
{
    /**
     * Menambah stok produk (Adjustment Masuk / Pembelian).
     */
    public function tambahStok(Produk $produk, $jumlah, $keterangan = 'Penyesuaian stok', $gudangId = 1)
    {
        DB::transaction(function () use ($produk, $jumlah, $keterangan, $gudangId) {
            $produk->increment('stok', $jumlah);

            DB::table('stok_gudang')->updateOrInsert(
                ['produk_id' => $produk->id, 'gudang_id' => $gudangId],
                ['jumlah' => DB::raw("jumlah + $jumlah"), 'diperbarui_pada' => now()]
            );

            DB::table('mutasi_stok')->insert([
                'produk_id' => $produk->id,
                'jumlah' => $jumlah,
                'jenis_mutasi' => 'masuk',
                'referensi_id' => 'ADJ-' . time(),
                'keterangan' => $keterangan,
                'oleh_pengguna_id' => auth()->id(),
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        });
    }

    /**
     * Mengurangi stok produk (Adjustment Keluar / Rusak).
     */
    public function kurangStok(Produk $produk, $jumlah, $keterangan = 'Penyesuaian stok', $gudangId = 1)
    {
        DB::transaction(function () use ($produk, $jumlah, $keterangan, $gudangId) {
            if ($produk->stok < $jumlah) {
                throw new Exception("Stok fisik tidak mencukupi untuk pengurangan.");
            }

            $produk->decrement('stok', $jumlah);

            DB::table('stok_gudang')
                ->where('produk_id', $produk->id)
                ->where('gudang_id', $gudangId)
                ->decrement('jumlah', $jumlah);

            DB::table('mutasi_stok')->insert([
                'produk_id' => $produk->id,
                'jumlah' => -$jumlah,
                'jenis_mutasi' => 'keluar',
                'referensi_id' => 'ADJ-' . time(),
                'keterangan' => $keterangan,
                'oleh_pengguna_id' => auth()->id(),
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        });
    }

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