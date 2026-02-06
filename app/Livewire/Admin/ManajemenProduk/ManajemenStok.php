<?php

namespace App\Livewire\Admin\ManajemenProduk;

use App\Helpers\LogHelper;
use App\Models\Gudang;
use App\Models\MutasiStok;
use App\Models\Produk;
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
    public $jenisAksi = 'penyesuaian'; // penyesuaian, penerimaan
    public $jumlahMutasi;
    public $keteranganMutasi = '';

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
        ]);

        $produk = Produk::find($this->produkTerpilihId);

        if ($this->jenisAksi === 'penyesuaian' && $produk->stok < $this->jumlahMutasi) {
            $this->addError('jumlahMutasi', 'Stok fisik tidak mencukupi untuk pengurangan ini.');
            return;
        }

        DB::transaction(function () use ($produk) {
            $jumlahFinal = $this->jenisAksi === 'penerimaan' ? $this->jumlahMutasi : -$this->jumlahMutasi;
            
            $produk->increment('stok', $jumlahFinal);

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
        });

        $this->reset(['produkTerpilihId', 'jumlahMutasi', 'keteranganMutasi']);
        $this->dispatch('close-slide-over', id: 'panel-mutasi');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Logistik berhasil diperbarui & tercatat di Jurnal Audit.']);
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
