<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\TiketBantuan;
use App\Models\KlaimGaransi;
use App\Models\Voucher;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Komponen Dasbor Pelanggan (Customer Hub)
 * 
 * Pusat kendali bagi pelanggan untuk memantau pesanan, poin loyalitas,
 * dompet digital, dan klaim garansi secara terpadu.
 */
class Beranda extends Component
{
    /**
     * Mengambil ringkasan data pelanggan untuk ditampilkan di dasbor.
     */
    public function getStatsProperty()
    {
        $pengguna = auth()->user();
        
        // Hitung Progres Loyalitas (Contoh logika: Level selanjutnya butuh 10.000 poin)
        $targetPoin = 10000;
        $progresLevel = min(100, ($pengguna->poin_loyalitas / $targetPoin) * 100);

        return [
            'nama' => $pengguna->nama,
            'email' => $pengguna->email,
            'poin' => $pengguna->poin_loyalitas ?? 0,
            'saldo' => $pengguna->saldo_digital ?? 0,
            'level' => $pengguna->level_member ?? 'Klasik',
            'progres_level' => $progresLevel,
            'pesanan_aktif' => Pesanan::where('pengguna_id', $pengguna->id)
                ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dikirim'])
                ->count(),
            'tiket_terbuka' => TiketBantuan::where('pengguna_id', $pengguna->id)
                ->whereIn('status', ['baru', 'terbuka', 'menunggu_pelanggan'])
                ->count(),
            'voucher_tersedia' => Voucher::where('aktif', true)
                ->where('berlaku_sampai', '>', now())
                ->count(),
        ];
    }

    /**
     * Mengambil riwayat transaksi pembayaran terbaru milik pengguna.
     */
    public function getTransaksiDompetProperty()
    {
        return \App\Models\TransaksiPembayaran::whereHas('pesanan', function($q) {
                $q->where('pengguna_id', auth()->id());
            })
            ->latest('waktu_bayar')
            ->take(3)
            ->get();
    }

    /**
     * Mengambil pesanan terbaru yang sedang berjalan untuk visualisasi timeline.
     */
    public function getPesananBerjalanProperty()
    {
        return Pesanan::where('pengguna_id', auth()->id())
            ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dikirim'])
            ->latest('dibuat_pada')
            ->first();
    }

    /**
     * Mengambil 5 riwayat pesanan terakhir.
     */
    public function getPesananTerakhirProperty()
    {
        return Pesanan::where('pengguna_id', auth()->id())
            ->latest('dibuat_pada')
            ->take(5)
            ->get();
    }

    /**
     * Produk rekomendasi berdasarkan algoritma cerdas (In Random Order).
     */
    public function getRekomendasiProperty()
    {
        return Produk::where('status', 'aktif')
            ->with(['gambar', 'kategori'])
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    #[Title('Personal Command Center - TEQARA')]
    public function render()
    {
        return view('livewire.pelanggan.beranda')
            ->layout('components.layouts.app');
    }
}
