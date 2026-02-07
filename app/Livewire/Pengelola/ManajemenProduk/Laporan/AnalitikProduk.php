<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Laporan;

use App\Models\DetailPesanan;
use App\Models\MutasiStok;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class AnalitikProduk extends Component
{
    public $periode = 'bulan_ini'; // hari_ini, minggu_ini, bulan_ini, tahun_ini

    public function getWaktuMulaiProperty()
    {
        return match($this->periode) {
            'hari_ini' => now()->startOfDay(),
            'minggu_ini' => now()->startOfWeek(),
            'bulan_ini' => now()->startOfMonth(),
            'tahun_ini' => now()->startOfYear(),
        };
    }

    #[Title('Analitik Produk & Performa - Teqara Admin')]
    public function render()
    {
        // 1. Produk Terlaris (Top Selling)
        $topProduk = DetailPesanan::select('produk_id', DB::raw('SUM(jumlah) as total_terjual'), DB::raw('SUM(subtotal) as total_omset'))
            ->where('dibuat_pada', '>=', $this->waktuMulai)
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->with('produk')
            ->take(5)
            ->get();

        // 2. Produk Margin Tertinggi (Profitabilitas)
        // Asumsi margin = (harga_jual - harga_modal) * terjual
        // Perlu join ke produk untuk ambil harga modal saat ini (simplifikasi)
        $topMargin = DetailPesanan::select('detail_pesanan.produk_id', 
                DB::raw('SUM((detail_pesanan.harga_saat_ini - produk.harga_modal) * detail_pesanan.jumlah) as total_margin'))
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->where('detail_pesanan.dibuat_pada', '>=', $this->waktuMulai)
            ->groupBy('detail_pesanan.produk_id')
            ->orderByDesc('total_margin')
            ->with('produk')
            ->take(5)
            ->get();

        // 3. Stok Mati (Slow Moving)
        // Produk yang tidak ada transaksi keluar dalam 30 hari terakhir tapi stok > 0
        $slowMoving = Produk::whereDoesntHave('detailPesanan', function($q) {
                $q->where('dibuat_pada', '>=', now()->subDays(30));
            })
            ->where('stok', '>', 0)
            ->take(5)
            ->get();

        // 4. Pergerakan Stok (Mutasi)
        $mutasiMasuk = MutasiStok::where('jenis_mutasi', 'masuk')
            ->where('dibuat_pada', '>=', $this->waktuMulai)
            ->sum('jumlah');
            
        $mutasiKeluar = MutasiStok::where('jenis_mutasi', 'keluar') // atau penjualan
            ->where('dibuat_pada', '>=', $this->waktuMulai)
            ->sum('jumlah');

        return view('livewire.pengelola.manajemen-produk.laporan.analitik-produk', [
            'topProduk' => $topProduk,
            'topMargin' => $topMargin,
            'slowMoving' => $slowMoving,
            'mutasi' => [
                'masuk' => $mutasiMasuk,
                'keluar' => abs($mutasiKeluar), // Asumsi keluar disimpan negatif
            ]
        ])->layout('components.layouts.admin');
    }
}
