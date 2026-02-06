<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Gudang;
use App\Models\MutasiStok;
use App\Models\Produk;
use App\Models\StokGudang;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenStok
 * Tujuan: Pusat kendali inventaris Enterprise dengan audit trail mendalam dan forecasting.
 */
class ManajemenStok extends Component
{
    use WithPagination;

    // State Filter
    public $cari = '';
    public $filterKesehatan = ''; // kritis, habis, aman, overstock
    public $tabAktif = 'posisi'; // posisi, mutasi

    // State Mutasi
    public $produkTerpilihId;
    public $jenisAksi = 'penyesuaian'; // penyesuaian, penerimaan, transfer
    public $jumlahMutasi;
    public $keteranganMutasi = '';
    
    // State Transfer Gudang
    public $dariGudangId;
    public $keGudangId;

    public function updated($property)
    {
        if (in_array($property, ['cari', 'filterKesehatan', 'tabAktif'])) {
            $this->resetPage();
        }
    }

    public function getAnalitikProperty()
    {
        return [
            'valuasi' => Produk::sum(DB::raw('stok * harga_modal')),
            'total_unit' => Produk::sum('stok'),
            'kritis' => Produk::where('stok', '>', 0)->where('stok', '<=', 5)->count(),
            'habis' => Produk::where('stok', '<=', 0)->count(),
            'aman' => Produk::where('stok', '>', 5)->where('stok', '<=', 50)->count(),
            'overstock' => Produk::where('stok', '>', 50)->count(),
        ];
    }

    public function bukaMutasi($id, $aksi = 'penyesuaian')
    {
        $this->produkTerpilihId = $id;
        $this->jenisAksi = $aksi;
        $this->dispatch('open-slide-over', id: 'panel-mutasi');
    }

    public function eksekusiMutasi()
    {
        $this->validate([
            'produkTerpilihId' => 'required|exists:produk,id',
            'jumlahMutasi' => 'required|integer|min:1',
            'keteranganMutasi' => 'required|min:5',
            'dariGudangId' => 'required_if:jenisAksi,transfer',
            'keGudangId' => 'required_if:jenisAksi,transfer|different:dariGudangId',
        ]);

        $produk = Produk::find($this->produkTerpilihId);

        DB::transaction(function () use ($produk) {
            
            if ($this->jenisAksi === 'transfer') {
                // Logic Transfer Antar Gudang
                $stokAsal = StokGudang::firstOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => $this->dariGudangId],
                    ['jumlah' => 0]
                );

                if ($stokAsal->jumlah < $this->jumlahMutasi) {
                    // Fallback: Jika data stok gudang belum sinkron, cek stok global (untuk fase transisi)
                    // Namun idealnya strictly check warehouse stock.
                    // Kita asumsikan sistem ini enforce stok gudang.
                    throw new \Exception("Stok di gudang asal tidak mencukupi (Tersedia: {$stokAsal->jumlah}).");
                }

                $stokTujuan = StokGudang::firstOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => $this->keGudangId],
                    ['jumlah' => 0]
                );

                $stokAsal->decrement('jumlah', $this->jumlahMutasi);
                $stokTujuan->increment('jumlah', $this->jumlahMutasi);
                
                // Tidak ubah stok global produk, hanya lokasi.

                MutasiStok::create([
                    'produk_id' => $produk->id,
                    'jumlah' => 0, // Net zero global change
                    'jenis_mutasi' => 'transfer_gudang',
                    'keterangan' => "Transfer: " . Gudang::find($this->dariGudangId)->nama . " -> " . Gudang::find($this->keGudangId)->nama . ". " . $this->keteranganMutasi,
                    'pengguna_id' => auth()->id(),
                    'waktu' => now(),
                ]);

                LogHelper::catat(
                    'transfer_stok',
                    $produk->nama,
                    "Admin memindahkan {$this->jumlahMutasi} unit antar gudang."
                );

            } else {
                // Logic Penyesuaian / Penerimaan Global
                if ($this->jenisAksi === 'penyesuaian' && $produk->stok < $this->jumlahMutasi) {
                    throw new \Exception('Stok fisik global tidak mencukupi untuk pengurangan ini.');
                }

                $jumlahFinal = $this->jenisAksi === 'penerimaan' ? $this->jumlahMutasi : -$this->jumlahMutasi;
                $produk->increment('stok', $jumlahFinal);

                // Update gudang utama (Default ID 1) jika ada, agar sinkron
                StokGudang::updateOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => 1], // Asumsi ID 1 adalah Gudang Pusat
                    ['jumlah' => DB::raw("GREATEST(0, jumlah + $jumlahFinal)")]
                );

                MutasiStok::create([
                    'produk_id' => $produk->id,
                    'jumlah' => $jumlahFinal,
                    'jenis_mutasi' => $this->jenisAksi === 'penerimaan' ? 'masuk' : 'penyesuaian_manual',
                    'keterangan' => $this->keteranganMutasi,
                    'pengguna_id' => auth()->id(),
                    'waktu' => now(),
                ]);

                LogHelper::catat(
                    'mutasi_stok',
                    $produk->nama,
                    "Admin eksekusi " . strtoupper($this->jenisAksi) . ": " . ($jumlahFinal > 0 ? '+' : '') . "{$jumlahFinal} unit. Memo: {$this->keteranganMutasi}"
                );
            }
        });

        $this->reset(['produkTerpilihId', 'jumlahMutasi', 'keteranganMutasi', 'dariGudangId', 'keGudangId']);
        $this->dispatch('close-slide-over', id: 'panel-mutasi');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Operasi logistik berhasil dijalankan.']);
    }

    #[Title('Audit Inventaris Hub - Teqara Admin')]
    public function render()
    {
        // 1. Query Posisi Stok
        $queryProduk = Produk::query()
            ->with(['kategori', 'merek'])
            ->where('nama', 'like', '%'.$this->cari.'%');

        if ($this->filterKesehatan) {
            switch ($this->filterKesehatan) {
                case 'kritis': $queryProduk->where('stok', '>', 0)->where('stok', '<=', 5); break;
                case 'habis': $queryProduk->where('stok', '<=', 0); break;
                case 'aman': $queryProduk->where('stok', '>', 5)->where('stok', '<=', 50); break;
                case 'overstock': $queryProduk->where('stok', '>', 50); break;
            }
        }

        // 2. Query Jurnal Mutasi
        $queryMutasi = MutasiStok::with(['produk', 'pengguna'])->latest();

        return view('livewire.admin.manajemen-produk.manajemen-stok', [
            'stokGlobal' => $queryProduk->paginate(10, pageName: 'produk-page'),
            'jurnalMutasi' => $queryMutasi->paginate(15, pageName: 'mutasi-page'),
            'daftarGudang' => Gudang::all(),
        ])->layout('components.layouts.admin');
    }
}
