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
 * Tujuan: Audit dan manajemen mutasi inventaris antar gudang.
 */
class ManajemenStok extends Component
{
    use WithPagination;

    public $cari = '';

    public $produkTerpilihId;

    public $dariGudang;

    public $keGudang;

    public $jumlahMutasi;

    public $keteranganMutasi = '';

    #[Title('Audit Inventaris & Forecasting - Teqara')]
    public function render()
    {
        $query = Produk::query()
            ->with(['kategori', 'merek'])
            ->where('nama', 'like', '%'.$this->cari.'%');

        $stokGlobal = $query->paginate(10);

        // Analitik Enterprise
        $totalValuasi = Produk::sum(DB::raw('stok * harga_modal'));
        $totalUnit = Produk::sum('stok');
        $itemKritis = Produk::where('stok', '<=', 5)->count();
        $itemOverstock = Produk::where('stok', '>', 100)->count();

        // Data Mutasi untuk Audit Trail
        $mutasiTerbaru = MutasiStok::with(['produk', 'pengguna'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.manajemen-produk.manajemen-stok', [
            'stokGlobal' => $stokGlobal,
            'mutasiTerbaru' => $mutasiTerbaru,
            'daftarGudang' => Gudang::all(),
            'analitik' => [
                'valuasi' => $totalValuasi,
                'total_unit' => $totalUnit,
                'kritis' => $itemKritis,
                'overstock' => $itemOverstock,
            ],
        ])->layout('components.layouts.admin');
    }

    public function bukaMutasi($id)
    {
        $this->produkTerpilihId = $id;
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

        if ($produk->stok < $this->jumlahMutasi) {
            $this->addError('jumlahMutasi', 'Stok saat ini tidak mencukupi untuk mutasi keluar.');

            return;
        }

        DB::transaction(function () use ($produk) {
            $produk->decrement('stok', $this->jumlahMutasi);

            MutasiStok::create([
                'produk_id' => $produk->id,
                'jumlah' => -$this->jumlahMutasi,
                'jenis_mutasi' => 'penyesuaian_manual', // Bisa dikembangkan jadi 'pindah_gudang' dll
                'keterangan' => $this->keteranganMutasi,
                'pengguna_id' => auth()->id(), // Pastikan nama kolom di DB benar, biasanya pengguna_id atau oleh_pengguna_id
                'waktu' => now(),
            ]);

            LogHelper::catat(
                'mutasi_stok',
                $produk->nama,
                "Admin melakukan penyesuaian stok manual: -{$this->jumlahMutasi} unit. Alasan: {$this->keteranganMutasi}"
            );
        });

        $this->reset(['produkTerpilihId', 'jumlahMutasi', 'keteranganMutasi']);
        $this->dispatch('close-slide-over', id: 'panel-mutasi');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Penyesuaian inventaris berhasil dicatat dalam audit trail.']);
    }
}
