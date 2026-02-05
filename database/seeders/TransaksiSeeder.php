<?php

namespace Database\Seeders;

use App\Models\DetailPesanan;
use App\Models\LogAktivitas;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggan = Pengguna::where('peran', 'pelanggan')->get();
        $produk = Produk::all();

        if ($pelanggan->isEmpty() || $produk->isEmpty()) {
            return;
        }

        // Buat 50 Transaksi Dummy
        for ($i = 1; $i <= 50; $i++) {
            $user = $pelanggan->random();
            $jumlahItem = rand(1, 3);
            $totalHarga = 0;

            $pesanan = Pesanan::create([
                'nomor_faktur' => 'TEQ-'.date('Ymd').'-'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'pengguna_id' => $user->id,
                'total_harga' => 0,
                'status_pembayaran' => rand(0, 1) ? 'lunas' : 'belum_dibayar',
                'status_pesanan' => ['menunggu', 'diproses', 'dikirim', 'selesai'][rand(0, 3)],
                'alamat_pengiriman' => 'Alamat Pengiriman Dummy No. '.$i,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            for ($j = 0; $j < $jumlahItem; $j++) {
                $p = $produk->random();
                $qty = rand(1, 2);
                $subtotal = $p->harga_jual * $qty;

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $p->id,
                    'harga_saat_ini' => $p->harga_jual,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ]);

                $totalHarga += $subtotal;
            }

            $pesanan->update(['total_harga' => $totalHarga]);

            // Catat Log Aktivitas
            LogAktivitas::create([
                'pengguna_id' => $user->id,
                'aksi' => 'checkout',
                'target' => $pesanan->nomor_faktur,
                'pesan_naratif' => "Pelanggan {$user->nama} melakukan pemesanan baru #{$pesanan->nomor_faktur}",
                'waktu' => $pesanan->created_at,
            ]);
        }
    }
}
