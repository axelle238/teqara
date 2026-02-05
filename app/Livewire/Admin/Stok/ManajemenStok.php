<?php

namespace App\Livewire\Admin\Stok;

use App\Helpers\LogHelper;
use App\Models\Gudang;
use App\Models\MutasiStok;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenStok extends Component
{
    use WithPagination;

    public $cari = '';

    // State Mutasi
    public $produkTerpilihId;

    public $dariGudang;

    public $keGudang;

    public $jumlahMutasi;

    public $keteranganMutasi = '';

    #[Title('Audit Inventaris - Teqara')]
    public function render()
    {
        $stokGlobal = Produk::query()
            ->with(['kategori'])
            ->where('nama', 'like', '%'.$this->cari.'%')
            ->paginate(10);

        $mutasiTerbaru = MutasiStok::query()
            ->with(['produk', 'pengguna'])
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.admin.stok.manajemen-stok', [
            'stokGlobal' => $stokGlobal,
            'mutasiTerbaru' => $mutasiTerbaru,
            'daftarGudang' => Gudang::all(),
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
            'keGudang' => 'required|exists:gudang,id',
        ]);

        $produk = Produk::find($this->produkTerpilihId);

        DB::transaction(function () use ($produk) {
            // Sederhanakan: Kurangi stok global (Dalam enterprise nyata, kurangi stok per gudang)
            $produk->decrement('stok', $this->jumlahMutasi);

            // Catat Mutasi
            MutasiStok::create([
                'produk_id' => $produk->id,
                'jumlah' => -$this->jumlahMutasi,
                'jenis_mutasi' => 'pindah_gudang',
                'keterangan' => "Mutasi {$this->jumlahMutasi} unit ke gudang ID: {$this->keGudang}",
                'oleh_pengguna_id' => auth()->id(),
            ]);

            // Log Aktivitas
            LogHelper::catat(
                'mutasi_stok',
                $produk->nama,
                "Admin memindahkan {$this->jumlahMutasi} unit produk {$produk->nama}."
            );
        });

        $this->dispatch('close-slide-over', id: 'panel-mutasi');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Mutasi stok berhasil dieksekusi!']);
    }
}
