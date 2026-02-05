<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarLaporan extends Component
{
    use WithPagination;

    public $tanggalMulai;

    public $tanggalSelesai;

    public $statusFilter = 'lunas';

    public function mount()
    {
        // Default: Laporan bulan ini
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
        $totalOmzet = $pesananData->sum('total_harga');
        $totalPesanan = $pesananData->count();

        // Produk Terlaris
        $produkTerlaris = DetailPesanan::query()
            ->select('produk_id', DB::raw('SUM(jumlah) as total_terjual'), DB::raw('SUM(subtotal) as total_omzet'))
            ->whereIn('pesanan_id', $pesananData->pluck('id'))
            ->groupBy('produk_id')
            ->with('produk')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // Distribusi per Kategori (Simulasi via data pesanan yang difilter)
        $omzetPerKategori = [];
        foreach ($pesananData as $p) {
            foreach ($p->detailPesanan as $d) {
                $namaKat = $d->produk->kategori->nama ?? 'Tanpa Kategori';
                $omzetPerKategori[$namaKat] = ($omzetPerKategori[$namaKat] ?? 0) + $d->subtotal;
            }
        }
        arsort($omzetPerKategori);

        return view('livewire.admin.laporan.daftar-laporan', [
            'pesanan' => $query->latest()->paginate(15),
            'totalOmzet' => $totalOmzet,
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

        // Log Aktivitas Ekspor
        \App\Helpers\LogHelper::catat(
            'export_laporan',
            "Laporan {$this->tanggalMulai} s/d {$this->tanggalSelesai}",
            "Admin melakukan ekspor data laporan penjualan periode {$this->tanggalMulai} hingga {$this->tanggalSelesai}."
        );
    }
}
