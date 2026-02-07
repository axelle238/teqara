<?php

namespace App\Livewire\Pengelola\ManajemenProduk;

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
 * Komponen Manajemen Stok
 * 
 * Pusat kendali inventaris sistem yang mencatat mutasi, transfer gudang,
 * dan audit fisik stok tanpa penggunaan modal.
 */
class ManajemenStok extends Component
{
    use WithPagination;

    // Keadaan Tampilan
    public $tampilkanForm = false;

    // Pencarian dan Filter
    public $cari = '';
    public $filterKesehatan = ''; // kritis, habis, aman, berlebih
    public $tabAktif = 'posisi'; // posisi, mutasi

    // Keadaan Mutasi
    public $produkTerpilihId;
    public $jenisAksi = 'penyesuaian'; // penyesuaian, penerimaan, transfer
    public $jumlahMutasi;
    public $keteranganMutasi = '';
    
    // Keadaan Transfer Antar Gudang
    public $dariGudangId;
    public $keGudangId;

    /**
     * Reset halaman saat filter berubah.
     */
    public function updated($properti)
    {
        if (in_array($properti, ['cari', 'filterKesehatan', 'tabAktif'])) {
            $this->resetPage('produk-page');
            $this->resetPage('mutasi-page');
        }
    }

    /**
     * Data analitik ringkas untuk header.
     */
    public function getAnalitikProperty()
    {
        return [
            'valuasi' => Produk::sum(DB::raw('stok * harga_modal')),
            'total_unit' => Produk::sum('stok'),
            'kritis' => Produk::where('stok', '>', 0)->where('stok', '<=', 5)->count(),
            'habis' => Produk::where('stok', '<=', 0)->count(),
            'aman' => Produk::where('stok', '>', 5)->where('stok', '<=', 50)->count(),
            'berlebih' => Produk::where('stok', '>', 50)->count(),
        ];
    }

    /**
     * Menampilkan panel formulir mutasi.
     */
    public function bukaMutasi($id, $aksi = 'penyesuaian')
    {
        $this->produkTerpilihId = $id;
        $this->jenisAksi = $aksi;
        $this->tampilkanForm = true;
    }

    /**
     * Membatalkan operasi dan reset formulir.
     */
    public function batal()
    {
        $this->tampilkanForm = false;
        $this->reset(['produkTerpilihId', 'jumlahMutasi', 'keteranganMutasi', 'dariGudangId', 'keGudangId']);
    }

    /**
     * Menjalankan mutasi stok dengan audit trail naratif.
     */
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
        $dataLama = ['stok' => $produk->stok];

        DB::transaction(function () use ($produk, $dataLama) {
            
            if ($this->jenisAksi === 'transfer') {
                // Proses Transfer Antar Gudang
                $stokAsal = StokGudang::firstOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => $this->dariGudangId],
                    ['jumlah' => 0]
                );

                if ($stokAsal->jumlah < $this->jumlahMutasi) {
                    throw new \Exception("Stok di gudang asal tidak mencukupi (Tersedia: {$stokAsal->jumlah}).");
                }

                $stokTujuan = StokGudang::firstOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => $this->keGudangId],
                    ['jumlah' => 0]
                );

                $stokAsal->decrement('jumlah', $this->jumlahMutasi);
                $stokTujuan->increment('jumlah', $this->jumlahMutasi);
                
                MutasiStok::create([
                    'produk_id' => $produk->id,
                    'jumlah' => 0, 
                    'jenis_mutasi' => 'transfer_gudang',
                    'keterangan' => "Transfer: " . Gudang::find($this->dariGudangId)->nama . " -> " . Gudang::find($this->keGudangId)->nama . ". " . $this->keteranganMutasi,
                    'pengguna_id' => auth()->id(),
                    'waktu' => now(),
                ]);

                LogHelper::catat(
                    'Transfer Stok', 
                    $produk->nama, 
                    "Pengelola memindahkan {$this->jumlahMutasi} unit {$produk->nama} dari " . Gudang::find($this->dariGudangId)->nama . " ke " . Gudang::find($this->keGudangId)->nama . "."
                );

            } else {
                // Proses Penyesuaian atau Penerimaan Global
                $jumlahFinal = $this->jenisAksi === 'penerimaan' ? $this->jumlahMutasi : -$this->jumlahMutasi;
                
                if ($produk->stok + $jumlahFinal < 0) {
                     throw new \Exception('Operasi dibatalkan: Stok global tidak boleh menjadi negatif.');
                }

                $produk->increment('stok', $jumlahFinal);

                // Sinkronisasi ke gudang utama (ID 1)
                StokGudang::updateOrCreate(
                    ['produk_id' => $produk->id, 'gudang_id' => 1], 
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

                $narasi = $this->jenisAksi === 'penerimaan' 
                    ? "Penerimaan stok baru sebanyak {$this->jumlahMutasi} unit untuk {$produk->nama}."
                    : "Penyesuaian stok manual (pengurangan) sebanyak {$this->jumlahMutasi} unit untuk {$produk->nama}.";

                LogHelper::catat(
                    'Mutasi Stok',
                    $produk->nama,
                    $narasi . " Memo: {$this->keteranganMutasi}",
                    $dataLama,
                    ['stok' => $produk->fresh()->stok]
                );
            }
        });

        $this->tampilkanForm = false;
        $this->reset(['produkTerpilihId', 'jumlahMutasi', 'keteranganMutasi', 'dariGudangId', 'keGudangId']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Operasi stok berhasil dicatat ke dalam sistem.']);
    }

    /**
     * Render tampilan dasbor manajemen stok.
     */
    #[Title('Manajemen Stok Enterprise - Teqara')]
    public function render()
    {
        $queryProduk = Produk::query()
            ->with(['kategori', 'merek'])
            ->where('nama', 'like', '%'.$this->cari.'%');

        if ($this->filterKesehatan) {
            switch ($this->filterKesehatan) {
                case 'kritis': $queryProduk->where('stok', '>', 0)->where('stok', '<=', 5); break;
                case 'habis': $queryProduk->where('stok', '<=', 0); break;
                case 'aman': $queryProduk->where('stok', '>', 5)->where('stok', '<=', 50); break;
                case 'berlebih': $queryProduk->where('stok', '>', 50); break;
            }
        }

        $queryMutasi = MutasiStok::with(['produk', 'pengguna'])->latest('dibuat_pada');

        return view('livewire.pengelola.manajemen-produk.manajemen-stok', [
            'stokGlobal' => $queryProduk->paginate(10, pageName: 'produk-page'),
            'jurnalMutasi' => $queryMutasi->paginate(15, pageName: 'mutasi-page'),
            'daftarGudang' => Gudang::all(),
        ])->layout('components.layouts.admin', ['header' => 'Manajemen Stok']);
    }
}
