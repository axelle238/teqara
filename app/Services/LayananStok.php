<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Exception;

class LayananStok
{
    /**
     * Menahan stok saat pesanan dibuat (Pending Payment).
     */
    public function tahanStok(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;
                
                if ($produk->stok < $detail->jumlah) {
                    throw new Exception("Stok tidak cukup untuk produk: {$produk->nama}");
                }

                // Pindahkan stok ke 'ditahan'
                $produk->decrement('stok', $detail->jumlah);
                $produk->increment('stok_ditahan', $detail->jumlah);
            }
        });
    }

    /**
     * Memfinalisasi stok saat pembayaran lunas (Stok benar-benar keluar).
     */
    public function finalisasiStok(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;
                
                // Kurangi stok ditahan (karena barang dianggap sold out permanen)
                $produk->decrement('stok_ditahan', $detail->jumlah);

                // Catat Mutasi
                DB::table('mutasi_stok')->insert([
                    'produk_id' => $produk->id,
                    'jumlah' => -$detail->jumlah,
                    'jenis_mutasi' => 'penjualan',
                    'referensi_id' => $pesanan->nomor_invoice,
                    'keterangan' => 'Penjualan via Website',
                    'oleh_pengguna_id' => $pesanan->pengguna_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    /**
     * Mengembalikan stok jika pesanan dibatalkan/kadaluarsa.
     */
    public function kembalikanStok(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;

                // Kembalikan dari ditahan ke stok aktif
                $produk->decrement('stok_ditahan', $detail->jumlah);
                $produk->increment('stok', $detail->jumlah);

                // Catat Mutasi (Opsional, sebagai log pembatalan)
                DB::table('mutasi_stok')->insert([
                    'produk_id' => $produk->id,
                    'jumlah' => $detail->jumlah,
                    'jenis_mutasi' => 'batal_pesanan',
                    'referensi_id' => $pesanan->nomor_invoice,
                    'keterangan' => 'Pengembalian stok (Pesanan Batal)',
                    'oleh_pengguna_id' => auth()->id() ?? null, // Bisa sistem atau admin
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
    
    /**
     * Menambah stok manual (Restock Gudang).
     */
    public function tambahStok(Produk $produk, int $jumlah, string $keterangan = 'Restock Manual')
    {
        DB::transaction(function () use ($produk, $jumlah, $keterangan) {
            $produk->increment('stok', $jumlah);

            DB::table('mutasi_stok')->insert([
                'produk_id' => $produk->id,
                'jumlah' => $jumlah,
                'jenis_mutasi' => 'masuk_barang',
                'referensi_id' => null,
                'keterangan' => $keterangan,
                'oleh_pengguna_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}