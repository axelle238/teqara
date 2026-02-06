<?php

namespace App\Livewire\Pengelola\ManajemenProduk\StockOpname;

use App\Helpers\LogHelper;
use App\Models\DetailStockOpname;
use App\Models\MutasiStok;
use App\Models\Produk;
use App\Models\StockOpname;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailStockOpnameComp extends Component
{
    public StockOpname $so;
    public $detail = [];
    public $cariProduk = '';
    public $hasilPencarian = [];

    // State Input
    public $inputFisik = []; // Array [produk_id => jumlah]

    public function mount($id)
    {
        $this->so = StockOpname::with('detail.produk')->findOrFail($id);
        $this->muatDetail();
    }

    public function muatDetail()
    {
        $this->detail = $this->so->detail()->with('produk')->get();
    }

    public function updatedCariProduk()
    {
        if (strlen($this->cariProduk) > 2) {
            $this->hasilPencarian = Produk::where('nama', 'like', '%'.$this->cariProduk.'%')
                ->orWhere('kode_unit', 'like', '%'.$this->cariProduk.'%')
                ->take(5)
                ->get();
        } else {
            $this->hasilPencarian = [];
        }
    }

    public function tambahItem($produkId)
    {
        $produk = Produk::find($produkId);
        
        // Cek jika sudah ada
        $exist = DetailStockOpname::where('stock_opname_id', $this->so->id)
            ->where('produk_id', $produkId)
            ->first();

        if (!$exist) {
            DetailStockOpname::create([
                'stock_opname_id' => $this->so->id,
                'produk_id' => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik' => 0, // Default 0 sebelum dihitung
                'selisih' => 0 - $produk->stok,
            ]);
            
            // Ubah status jadi proses jika masih draft
            if ($this->so->status === 'draft') {
                $this->so->update(['status' => 'proses']);
            }
        }

        $this->reset(['cariProduk', 'hasilPencarian']);
        $this->muatDetail();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Item ditambahkan ke daftar hitung.']);
    }

    public function updateFisik($detailId, $jumlah)
    {
        $det = DetailStockOpname::find($detailId);
        if ($det) {
            $selisih = $jumlah - $det->stok_sistem;
            $det->update([
                'stok_fisik' => $jumlah,
                'selisih' => $selisih,
            ]);
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Hasil hitung disimpan.']);
        }
    }

    public function finalisasi()
    {
        if ($this->so->status === 'selesai') return;

        DB::transaction(function () {
            // 1. Eksekusi Penyesuaian Stok
            foreach ($this->so->detail as $item) {
                if ($item->selisih != 0) {
                    $item->produk->increment('stok', $item->selisih);
                    
                    MutasiStok::create([
                        'produk_id' => $item->produk_id,
                        'jumlah' => $item->selisih,
                        'jenis_mutasi' => 'stock_opname',
                        'keterangan' => "Penyesuaian SO #{$this->so->kode_so}",
                        'pengguna_id' => auth()->id(),
                        'waktu' => now(),
                    ]);
                }
            }

            // 2. Update Status SO
            $this->so->update([
                'status' => 'selesai',
                'tgl_selesai' => now(),
            ]);

            LogHelper::catat('finalisasi_so', $this->so->kode_so, "Stock Opname {$this->so->kode_so} selesai. Stok disesuaikan otomatis.");
        });

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Stock Opname Final! Inventaris telah diperbarui.']);
        $this->muatDetail(); // Refresh UI
    }

    #[Title('Detail Stock Opname - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.stock-opname.detail-stock-opname')
            ->layout('components.layouts.admin');
    }
}
