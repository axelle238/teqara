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
    use \Livewire\WithPagination;

    public $periode = 'bulan_ini'; // hari_ini, minggu_ini, bulan_ini, tahun_ini
    public $tabAktif = 'ringkasan'; // ringkasan, inventaris, audit

    // Data Grafik & Ringkasan
    public $chartPendapatan = [];
    public $chartPesanan = [];
    public $topProduk = [];
    public $topKategori = [];

    // Data Inventaris
    public $stokMati = [];

    // Filter Audit
    public $auditSearch = '';

    public function mount()
    {
        $this->generateLaporan();
    }

    public function updatedPeriode()
    {
        $this->generateLaporan();
        $this->dispatch('chart-updated'); 
    }

    public function gantiTab($tab)
    {
        $this->tabAktif = $tab;
        if($tab === 'ringkasan') {
            $this->dispatch('chart-updated');
        }
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

        // --- TAB RINGKASAN ---
        
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

        // --- TAB INVENTARIS (STOK MATI) ---
        // Produk yang tidak terjual dalam 30 hari terakhir tapi stok masih ada
        $produkTerjualIds = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.dibuat_pada', '>=', now()->subDays(30))
            ->pluck('produk_id')
            ->unique();

        $this->stokMati = Produk::whereNotIn('id', $produkTerjualIds)
            ->where('stok', '>', 0)
            ->with(['kategori'])
            ->orderByDesc('stok')
            ->limit(10)
            ->get();
    }

    public function getAuditLogsProperty()
    {
        return \App\Models\LogAktivitas::with('pengguna')
            ->when($this->auditSearch, function($q) {
                $q->where('pesan_naratif', 'like', '%'.$this->auditSearch.'%')
                  ->orWhere('aksi', 'like', '%'.$this->auditSearch.'%')
                  ->orWhereHas('pengguna', fn($u) => $u->where('nama', 'like', '%'.$this->auditSearch.'%'));
            })
            ->latest('waktu')
            ->paginate(10);
    }

    #[Title('Analitik Bisnis - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-laporan.beranda-laporan')
            ->layout('components.layouts.admin', ['header' => 'Intelijen Bisnis']);
    }
}
