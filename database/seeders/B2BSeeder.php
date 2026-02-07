<?php

namespace Database\Seeders;

use App\Models\ItemPenawaran;
use App\Models\PenawaranHarga;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class B2BSeeder extends Seeder
{
    /**
     * Jalankan seeder B2B RFQ.
     */
    public function run(): void
    {
        $pelanggan = Pengguna::where('peran', 'pelanggan')->get();
        $produk = Produk::all();

        if ($pelanggan->isEmpty() || $produk->isEmpty()) {
            return;
        }

        // Buat 10 RFQ Dummy
        for ($i = 1; $i <= 10; $i++) {
            $user = $pelanggan->random();
            $status = ['pending', 'dibalas', 'disetujui', 'ditolak'][rand(0, 3)];
            
            $penawaran = PenawaranHarga::create([
                'pengguna_id' => $user->id,
                'total_pengajuan' => 0,
                'status' => $status,
                'pesan_pelanggan' => "Mohon penawaran harga khusus untuk pengadaan kantor kami. Terima kasih.",
                'pesan_admin' => $status !== 'pending' ? "Berikut harga khusus yang bisa kami berikan untuk volume pesanan Anda." : null,
                'berlaku_sampai' => now()->addDays(7),
                'dibuat_pada' => now()->subDays(rand(1, 5)),
            ]);

            $jumlahItem = rand(1, 3);
            $total = 0;

            for ($j = 0; $j < $jumlahItem; $j++) {
                $p = $produk->random();
                $qty = rand(5, 20); // Volume B2B
                $hargaTawar = $status !== 'pending' ? ($p->harga_jual * 0.9) : null;

                ItemPenawaran::create([
                    'penawaran_id' => $penawaran->id,
                    'produk_id' => $p->id,
                    'jumlah' => $qty,
                    'harga_tawar_satuan' => $hargaTawar,
                ]);

                $total += ($hargaTawar ?? $p->harga_jual) * $qty;
            }

            $penawaran->update(['total_pengajuan' => $total]);
        }
    }
}