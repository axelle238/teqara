<?php

namespace App\Livewire\Admin\ManajemenProduk\Pembelian;

use App\Helpers\LogHelper;
use App\Models\DetailPembelian;
use App\Models\MutasiStok;
use App\Models\Pemasok;
use App\Models\PembelianStok;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatPembelian extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public function buatBaru()
    {
        // Redirect ke form tambah (bisa component baru atau slide-over)
        // Untuk simplifikasi, kita buat form baru via slide-over di component terpisah atau redirect
        return redirect()->route('admin.produk.pembelian.baru');
    }

    #[Title('Manajemen Pembelian Stok - Teqara Admin')]
    public function render()
    {
        $riwayat = PembelianStok::with('pemasok')
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manajemen-produk.pembelian.riwayat-pembelian', [
            'riwayat' => $riwayat,
            'stats' => [
                'total_transaksi' => PembelianStok::count(),
                'total_pengeluaran' => PembelianStok::where('status', 'selesai')->sum('total_biaya'),
                'draft' => PembelianStok::where('status', 'draft')->count(),
            ]
        ])->layout('components.layouts.admin');
    }
}
