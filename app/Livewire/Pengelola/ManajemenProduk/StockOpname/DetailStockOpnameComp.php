<?php

namespace App\Livewire\Pengelola\ManajemenProduk\StockOpname;

use App\Helpers\LogHelper;
use App\Models\DetailStockOpname;
use App\Models\Produk;
use App\Models\StockOpname;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailStockOpnameComp extends Component
{
    public $soId;
    public $so;
    public $cariProduk = '';
    public $hasilPencarian = [];
    
    // Input
    public $inputFisik = [];
    public $catatanItem = [];

    public function mount($id)
    {
        $this->soId = $id;
        $this->loadSo();
    }

    public function loadSo()
    {
        $this->so = StockOpname::with(['detail.produk', 'petugas'])->findOrFail($this->soId);
        
        // Init input
        foreach ($this->so->detail as $d) {
            $this->inputFisik[$d->id] = $d->stok_fisik;
            $this->catatanItem[$d->id] = $d->catatan;
        }
    }

    public function updatedCariProduk()
    {
        if (strlen($this->cariProduk) > 2) {
            $this->hasilPencarian = Produk::where('nama', 'like', '%'.$this->cariProduk.'%')
                ->orWhere('kode_unit', 'like', '%'.$this->cariProduk.'%')
                ->take(5)->get();
        } else {
            $this->hasilPencarian = [];
        }
    }

    public function tambahProduk($produkId)
    {
        $produk = Produk::find($produkId);
        
        // Cek duplikasi di detail
        $exist = DetailStockOpname::where('stock_opname_id', $this->so->id)
            ->where('produk_id', $produkId)
            ->first();

        if (!$exist) {
            $detail = DetailStockOpname::create([
                'stock_opname_id' => $this->so->id,
                'produk_id' => $produkId,
                'stok_sistem' => $produk->stok,
                'stok_fisik' => 0, // Default 0
                'selisih' => -$produk->stok, // Awalnya selisih full minus
            ]);
            
            $this->inputFisik[$detail->id] = 0;
        }

        $this->reset(['cariProduk', 'hasilPencarian']);
        $this->loadSo();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Produk ditambahkan ke list audit.']);
    }

    public function simpanProgress()
    {
        foreach ($this->inputFisik as $detailId => $fisik) {
            $detail = DetailStockOpname::find($detailId);
            if ($detail) {
                $selisih = $fisik - $detail->stok_sistem;
                $detail->update([
                    'stok_fisik' => $fisik,
                    'selisih' => $selisih,
                    'catatan' => $this->catatanItem[$detailId] ?? null
                ]);
            }
        }
        
        $this->loadSo();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Progress audit tersimpan.']);
    }

    public function selesaiAudit()
    {
        $this->simpanProgress();
        
        // Finalisasi: Update stok master sesuai fisik
        // (Opsional: tergantung kebijakan, apakah auto-adjust atau perlu approval manager)
        // Di sini kita auto-adjust untuk simplifikasi enterprise flow
        
        foreach ($this->so->detail as $detail) {
            if ($detail->selisih != 0) {
                (new \App\Services\LayananStok)->sesuaikanStok(
                    $detail->produk, 
                    $detail->stok_fisik, 
                    "Hasil Stock Opname #{$this->so->kode_so}"
                );
            }
        }

        $this->so->update(['status' => 'selesai', 'tgl_selesai' => now()]);
        
        LogHelper::catat('selesai_so', $this->so->kode_so, "Audit stok selesai. Stok inventaris telah disesuaikan.");
        
        return redirect()->route('pengelola.produk.so.riwayat');
    }

    #[Title('Lembar Kerja Audit Stok - Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.stock-opname.detail-stock-opname-comp')
            ->layout('components.layouts.admin');
    }
}