<?php

namespace App\Livewire\Pengelola\ManajemenLaporan;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

/**
 * Class BerandaLaporan
 * Tujuan: Pusat analitik bisnis enterprise (Business Intelligence).
 * Arsitektur: Full Page Dashboard dengan visualisasi data interaktif.
 */
class BerandaLaporan extends Component
{
    public $periode = 'bulan_ini'; // hari_ini, minggu_ini, bulan_ini, tahun_ini

    // Data Grafik
    public $chartPendapatan = [];
    public $chartPesanan = [];
    public $topProduk = [];
    public $topKategori = [];

    public function mount()
    {
        $this->generateLaporan();
    }

    public function updatedPeriode()
    {
        $this->generateLaporan();
    }

    private function getRange()
    {
        return match($this->periode) {
            'hari_ini' => [now()->startOfDay(), now()->endOfDay()],
            'minggu_ini' => [now()->startOfWeek(), now()->endOfWeek()],
            'tahun_ini' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()], // bulan_ini
        };
    }

    public function generateLaporan()
    {
        [$start, $end] = $this->getRange();

        // 1. Grafik Pendapatan & Pesanan Harian
        $dataHarian = Pesanan::select(
                DB::raw('DATE(dibuat_pada) as tanggal'), 
                DB::raw('SUM(total_harga) as total_omzet'),
                DB::raw('COUNT(*) as jumlah_transaksi')
            )
            ->whereBetween('dibuat_pada', [$start, $end])
            ->where('status_pembayaran', 'lunas')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $this->chartPendapatan = [
            'labels' => $dataHarian->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $dataHarian->pluck('total_omzet')->toArray()
        ];

        $this->chartPesanan = [
            'labels' => $dataHarian->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $dataHarian->pluck('jumlah_transaksi')->toArray()
        ];

        // 2. Top Produk Terlaris
        $this->topProduk = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->whereBetween('pesanan.dibuat_pada', [$start, $end])
            ->where('pesanan.status_pembayaran', 'lunas')
            ->select('produk.nama', DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'), DB::raw('SUM(detail_pesanan.subtotal) as total_revenue'))
            ->groupBy('produk.id', 'produk.nama')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // 3. Kategori Terpopuler
        $this->topKategori = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->whereBetween('pesanan.dibuat_pada', [$start, $end])
            ->select('kategori.nama', DB::raw('COUNT(*) as frekuensi'))
            ->groupBy('kategori.id', 'kategori.nama')
            ->orderByDesc('frekuensi')
            ->limit(5)
            ->get();
    }

    #[Title('Analitik Bisnis - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-laporan.beranda-laporan')
            ->layout('components.layouts.admin', ['header' => 'Intelijen Bisnis']);
    }
}