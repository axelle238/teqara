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
        
        return [
            'nama' => $pengguna->nama,
            'email' => $pengguna->email,
            'poin' => $pengguna->poin_loyalitas ?? 0,
            'saldo' => $pengguna->saldo_digital ?? 0,
            'level' => $pengguna->level_member ?? 'Klasik',
            'pesanan_aktif' => Pesanan::where('pengguna_id', $pengguna->id)
                ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dikirim'])
                ->count(),
            'tiket_terbuka' => TiketBantuan::where('pengguna_id', $pengguna->id)
                ->where('status', 'terbuka')
                ->count(),
            'voucher_tersedia' => Voucher::where('aktif', true)
                ->where('berlaku_sampai', '>', now())
                ->count(),
            'klaim_garansi' => KlaimGaransi::where('pelanggan_id', $pengguna->id)
                ->where('status', '!=', 'selesai')
                ->count(),
        ];
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
     * Produk rekomendasi berdasarkan algoritma acak (Dapat ditingkatkan).
     */
    public function getRekomendasiProperty()
    {
        return Produk::where('status', 'aktif')
            ->with(['gambar', 'kategori'])
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    #[Title('Dasbor Pelanggan - TEQARA Experience')]
    public function render()
    {
        return view('livewire.pelanggan.beranda')
            ->layout('components.layouts.app');
    }
}