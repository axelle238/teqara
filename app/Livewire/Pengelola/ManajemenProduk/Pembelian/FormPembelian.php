<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Pembelian;

use App\Helpers\LogHelper;
use App\Models\DetailPembelian;
use App\Models\Pemasok;
use App\Models\PembelianStok;
use App\Models\Produk;
use App\Services\LayananStok;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Class FormPembelian
 * Tujuan: Input Purchase Order (PO) ke supplier.
 */
class FormPembelian extends Component
{
    // Mode: 'create' atau 'edit' (untuk draft)
    public $mode = 'create';
    public $pembelianId;

    // Form
    public $pemasok_id;
    public $nomor_referensi; // No Invoice dari Supplier
    public $tanggal;
    public $status = 'draft'; // draft, dipesan, diterima, selesai
    public $catatan;
    
    // Items: [[produk_id, harga_beli, jumlah, subtotal]]
    public $items = []; 
    
    // Search Helper
    public $cariProduk = '';
    public $hasilPencarian = [];

    public function mount($id = null)
    {
        $this->tanggal = now()->format('Y-m-d');
        
        if ($id) {
            $this->mode = 'edit';
            $this->pembelianId = $id;
            $this->loadData();
        } else {
            // Init baris pertama kosong
            // $this->tambahBaris(); 
        }
    }

    public function loadData()
    {
        $po = PembelianStok::with('detail.produk')->findOrFail($this->pembelianId);
        $this->pemasok_id = $po->pemasok_id;
        $this->nomor_referensi = $po->nomor_referensi;
        $this->tanggal = $po->tanggal_pembelian->format('Y-m-d');
        $this->status = $po->status;
        $this->catatan = $po->catatan;

        foreach ($po->detail as $d) {
            $this->items[] = [
                'produk_id' => $d->produk_id,
                'nama' => $d->produk->nama,
                'kode' => $d->produk->kode_unit,
                'harga_beli' => $d->harga_beli_satuan,
                'jumlah' => $d->jumlah_dipesan,
                'subtotal' => $d->subtotal
            ];
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

    public function tambahItem($id)
    {
        $produk = Produk::find($id);
        
        // Cek duplikasi
        foreach ($this->items as $idx => $item) {
            if ($item['produk_id'] == $id) {
                // Increment qty
                $this->items[$idx]['jumlah']++;
                $this->hitungSubtotal($idx);
                $this->reset(['cariProduk', 'hasilPencarian']);
                return;
            }
        }

        $this->items[] = [
            'produk_id' => $produk->id,
            'nama' => $produk->nama,
            'kode' => $produk->kode_unit,
            'harga_beli' => $produk->harga_modal, // Default ke harga modal saat ini
            'jumlah' => 1,
            'subtotal' => $produk->harga_modal
        ];

        $this->reset(['cariProduk', 'hasilPencarian']);
    }

    public function hitungSubtotal($index)
    {
        $this->items[$index]['subtotal'] = $this->items[$index]['harga_beli'] * $this->items[$index]['jumlah'];
    }

    public function hapusItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function getTotalProperty()
    {
        return array_sum(array_column($this->items, 'subtotal'));
    }

    public function simpan()
    {
        $this->validate([
            'pemasok_id' => 'required',
            'items' => 'required|array|min:1',
            'items.*.jumlah' => 'required|numeric|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
        ]);

        $data = [
            'pemasok_id' => $this->pemasok_id,
            'nomor_referensi' => $this->nomor_referensi,
            'tanggal_pembelian' => $this->tanggal,
            'status' => $this->status,
            'total_biaya' => $this->total,
            'catatan' => $this->catatan,
            'pengguna_id' => auth()->id(),
        ];

        if ($this->mode == 'edit') {
            $po = PembelianStok::find($this->pembelianId);
            $po->update($data);
            $po->detail()->delete(); // Reset detail
        } else {
            $data['kode_pembelian'] = 'PO-'.date('ymd').'-'.strtoupper(bin2hex(random_bytes(2)));
            $po = PembelianStok::create($data);
        }

        foreach ($this->items as $item) {
            DetailPembelian::create([
                'pembelian_stok_id' => $po->id,
                'produk_id' => $item['produk_id'],
                'harga_beli_satuan' => $item['harga_beli'],
                'jumlah_dipesan' => $item['jumlah'],
                'jumlah_diterima' => $this->status == 'selesai' ? $item['jumlah'] : 0, // Auto receive if selesai
                'subtotal' => $item['subtotal']
            ]);

            // Jika status langsung selesai, update stok produk
            if ($this->status == 'selesai') {
                $produk = Produk::find($item['produk_id']);
                (new LayananStok)->tambahStok($produk, $item['jumlah'], "Penerimaan PO #{$po->kode_pembelian}");
                
                // Update HPP (Weighted Average bisa diterapkan di sini, tapi kita update sederhana dulu)
                $produk->update(['harga_modal' => $item['harga_beli']]);
            }
        }

        LogHelper::catat($this->mode == 'edit' ? 'update_po' : 'buat_po', $po->kode_pembelian, "Order Pembelian disimpan dengan status {$this->status}");

        return redirect()->route('pengelola.produk.pembelian.riwayat')
            ->with('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Purchase Order berhasil disimpan.']);
    }

    #[Title('Form Purchase Order - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.pembelian.form-pembelian', [
            'pemasokList' => Pemasok::orderBy('nama_perusahaan')->get()
        ])->layout('components.layouts.admin');
    }
}