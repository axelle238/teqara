<?php

namespace App\Livewire\Admin\ManajemenLaporan;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class BerandaLaporan
 * Tujuan: Manajemen laporan keuangan, profit, dan analitik performa bisnis.
 */
class BerandaLaporan extends Component
{
    use WithPagination;

    public $tanggalMulai;

    public $tanggalSelesai;

    public $statusFilter = 'lunas';

    public function mount()
    {
        $this->tanggalMulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggalSelesai = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updated()
    {
        $this->resetPage();
    }

    #[Title('Analitik & Laporan Penjualan - Admin Teqara')]
    public function render()
    {
        $rentangTanggal = [
            $this->tanggalMulai.' 00:00:00',
            $this->tanggalSelesai.' 23:59:59',
        ];

        $query = Pesanan::query()
            ->with(['pengguna', 'detailPesanan.produk'])
            ->whereBetween('created_at', $rentangTanggal);

        if ($this->statusFilter) {
            $query->where('status_pembayaran', $this->statusFilter);
        }

        $pesananData = $query->get();

        // Hitung Finansial Detail
        $totalOmzet = 0;
        $totalModal = 0;

        foreach ($pesananData as $p) {
            $totalOmzet += $p->total_harga;
            foreach ($p->detailPesanan as $d) {
                // Asumsi harga modal statis dari master produk saat ini (ideal snapshot di detail_pesanan, tapi kita pakai master dulu)
                $totalModal += ($d->produk->harga_modal * $d->jumlah);
            }
        }

        $totalProfit = $totalOmzet - $totalModal;
        $marginProfit = $totalOmzet > 0 ? ($totalProfit / $totalOmzet) * 100 : 0;
        $totalPesanan = $pesananData->count();

        $produkTerlaris = DetailPesanan::query()
            ->select('produk_id', DB::raw('SUM(jumlah) as total_terjual'), DB::raw('SUM(subtotal) as total_omzet'))
            ->whereIn('pesanan_id', $pesananData->pluck('id'))
            ->groupBy('produk_id')
            ->with('produk')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        $omzetPerKategori = [];
        foreach ($pesananData as $p) {
            foreach ($p->detailPesanan as $d) {
                $namaKat = $d->produk->kategori->nama ?? 'Tanpa Kategori';
                $omzetPerKategori[$namaKat] = ($omzetPerKategori[$namaKat] ?? 0) + $d->subtotal;
            }
        }
        arsort($omzetPerKategori);

        return view('livewire.admin.manajemen-laporan.beranda-laporan', [
            'pesanan' => $query->latest()->paginate(15),
            'totalOmzet' => $totalOmzet,
            'totalModal' => $totalModal,
            'totalProfit' => $totalProfit,
            'marginProfit' => $marginProfit,
            'totalPesanan' => $totalPesanan,
            'produkTerlaris' => $produkTerlaris,
            'omzetPerKategori' => $omzetPerKategori,
        ])->layout('components.layouts.admin');
    }

    public function eksporExcel()
    {
        $this->dispatch('notifikasi', [
            'tipe' => 'info',
            'pesan' => 'Sedang menyiapkan data laporan untuk diunduh (XLSX)...',
        ]);

        \App\Helpers\LogHelper::catat(
            'ekspor_laporan',
            "Laporan {$this->tanggalMulai} s/d {$this->tanggalSelesai}",
            "Admin melakukan ekspor data laporan penjualan periode {$this->tanggalMulai} hingga {$this->tanggalSelesai}."
        );
    }
}
