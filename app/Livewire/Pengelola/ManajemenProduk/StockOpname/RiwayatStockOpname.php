<?php

namespace App\Livewire\Pengelola\ManajemenProduk\StockOpname;

use App\Helpers\LogHelper;
use App\Models\DetailStockOpname;
use App\Models\Produk;
use App\Models\StockOpname;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class RiwayatStockOpname
 * Tujuan: Dashboard utama manajemen audit fisik stok (Stock Opname).
 */
class RiwayatStockOpname extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public function mulaiSesiBaru()
    {
        $kodeSo = 'SO-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(2)));
        
        $so = StockOpname::create([
            'kode_so' => $kodeSo,
            'petugas_id' => auth()->id(),
            'tgl_mulai' => now(),
            'status' => 'draft',
        ]);

        return redirect()->route('pengelola.produk.so.detail', $so->id);
    }

    #[Title('Stock Opname - Admin Teqara')]
    public function render()
    {
        $riwayat = StockOpname::with('petugas')
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.pengelola.manajemen-produk.stock-opname.riwayat-stock-opname', [
            'riwayat' => $riwayat,
            'stats' => [
                'total' => StockOpname::count(),
                'proses' => StockOpname::where('status', 'proses')->count(),
                'selesai' => StockOpname::where('status', 'selesai')->count(),
            ]
        ])->layout('components.layouts.admin');
    }
}
