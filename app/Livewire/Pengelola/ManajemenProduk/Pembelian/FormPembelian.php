<?php

namespace App\Livewire\Pengelola\ManajemenProduk\Pembelian;

use App\Helpers\LogHelper;
use App\Models\DetailPembelian;
use App\Models\MutasiStok;
use App\Models\Pemasok;
use App\Models\PembelianStok;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class FormPembelian extends Component
{
    public $pembelianId;
    public $pembelian;
    public $pemasok_id;
    public $tgl_beli;
    public $status = 'draft';
    
    // Item Form
    public $cariProduk = '';
    public $hasilPencarian = [];
    public $items = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->pembelianId = $id;
            $this->pembelian = PembelianStok::with('detail.produk')->findOrFail($id);
            $this->pemasok_id = $this->pembelian->pemasok_id;
            $this->tgl_beli = $this->pembelian->tgl_beli->format('Y-m-d');
            $this->status = $this->pembelian->status;
            
            foreach ($this->pembelian->detail as $det) {
                $this->items[] = [
                    'produk_id' => $det->produk_id,
                    'nama' => $det->produk->nama,
                    'kode_unit' => $det->produk->kode_unit,
                    'harga_beli' => $det->harga_beli,
                    'jumlah' => $det->jumlah,
                    'subtotal' => $det->subtotal,
                ];
            }
        } else {
            $this->tgl_beli = date('Y-m-d');
        }
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

    public function tambahItem($id)
    {
        $produk = Produk::find($id);
        
        // Cek duplikasi di list items
        foreach ($this->items as $item) {
            if ($item['produk_id'] == $id) {
                return;
            }
        }

        $this->items[] = [
            'produk_id' => $produk->id,
            'nama' => $produk->nama,
            'kode_unit' => $produk->kode_unit,
            'harga_beli' => $produk->harga_modal, // Default
            'jumlah' => 1,
            'subtotal' => $produk->harga_modal,
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

    public function simpan($final = false)
    {
        $this->validate([
            'pemasok_id' => 'required',
            'tgl_beli' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($final) {
            $data = [
                'pemasok_id' => $this->pemasok_id,
                'tgl_beli' => $this->tgl_beli,
                'total_biaya' => collect($this->items)->sum('subtotal'),
                'status' => $final ? 'selesai' : 'draft',
            ];

            if ($this->pembelianId) {
                $pembelian = PembelianStok::find($this->pembelianId);
                $pembelian->update($data);
                DetailPembelian::where('pembelian_id', $pembelian->id)->delete();
            } else {
                $data['no_faktur'] = 'PO-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(2)));
                $pembelian = PembelianStok::create($data);
                $this->pembelianId = $pembelian->id;
            }

            foreach ($this->items as $item) {
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'produk_id' => $item['produk_id'],
                    'harga_beli' => $item['harga_beli'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

                if ($final) {
                    // Update Stok Produk & Harga Modal
                    $produk = Produk::find($item['produk_id']);
                    $produk->increment('stok', $item['jumlah']);
                    $produk->update(['harga_modal' => $item['harga_beli']]); // Update harga modal terbaru

                    // Catat Mutasi
                    MutasiStok::create([
                        'produk_id' => $item['produk_id'],
                        'jumlah' => $item['jumlah'],
                        'jenis_mutasi' => 'pembelian',
                        'keterangan' => "Pembelian PO #{$pembelian->no_faktur}",
                        'pengguna_id' => auth()->id(),
                        'waktu' => now(),
                    ]);
                }
            }

            if ($final) {
                LogHelper::catat('finalisasi_pembelian', $pembelian->no_faktur, "Pembelian stok senilai Rp ".number_format($pembelian->total_biaya)." berhasil difinalisasi.");
            }
        });

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Data pembelian berhasil disimpan.']);
        return redirect()->route('pengelola.produk.pembelian.riwayat');
    }

    #[Title('Form Pembelian - Admin Teqara')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-produk.pembelian.form-pembelian', [
            'daftarPemasok' => Pemasok::all(),
        ])->layout('components.layouts.admin');
    }
}
