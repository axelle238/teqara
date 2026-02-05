<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * LayananStok Enterprise v2.2
 * Mendukung mutasi antar gudang dan pencatatan nomor seri.
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
                    throw new Exception("Stok fisik tidak cukup untuk: {$produk->nama}");
                }

                $produk->decrement('stok', $detail->jumlah);
                $produk->increment('stok_ditahan', $detail->jumlah);
            }
        });
    }

    /**
     * Finalisasi stok saat pembayaran lunas.
     * Mengurangi stok dari Gudang Toko Utama (ID: 1).
     */
    public function finalisasiStok(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;
                
                $produk->decrement('stok_ditahan', $detail->jumlah);

                // Kurangi Stok dari Gudang (Default: Toko Utama ID 1)
                DB::table('stok_gudang')
                    ->where('produk_id', $produk->id)
                    ->where('gudang_id', 1)
                    ->decrement('jumlah', $detail->jumlah);

                // Catat Mutasi
                DB::table('mutasi_stok')->insert([
                    'produk_id' => $produk->id,
                    'jumlah' => -$detail->jumlah,
                    'jenis_mutasi' => 'penjualan',
                    'referensi_id' => $pesanan->nomor_invoice,
                    'keterangan' => 'Penjualan Invoice ' . $pesanan->nomor_invoice,
                    'oleh_pengguna_id' => $pesanan->pengguna_id,
                    'created_at' => now(),
                    'updated_at' => now(),
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
            // Kurangi dari asal
            DB::table('stok_gudang')
                ->where('produk_id', $produkId)
                ->where('gudang_id', $dariGudangId)
                ->decrement('jumlah', $jumlah);

            // Tambah ke tujuan
            DB::table('stok_gudang')->updateOrInsert(
                ['produk_id' => $produkId, 'gudang_id' => $keGudangId],
                ['jumlah' => DB::raw("jumlah + $jumlah"), 'updated_at' => now()]
            );

            // Audit Trail
            DB::table('mutasi_stok')->insert([
                'produk_id' => $produkId,
                'jumlah' => 0, // Netto 0 karena hanya pindah internal
                'jenis_mutasi' => 'pindah_gudang',
                'keterangan' => "Transfer gudang: $keterangan",
                'oleh_pengguna_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
