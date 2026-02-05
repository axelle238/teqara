<?php

namespace App\Livewire\Admin\Stok;

use App\Models\Produk;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class ManajemenStok extends Component
{
    use WithPagination;

    public $cari = '';
    
    // State Mutasi
    public $produkTerpilihId;
    public $dariGudang, $keGudang, $jumlahMutasi;

    #[Title('Audit Inventaris - Teqara')]
    public function render()
    {
        $stokGlobal = DB::table('produk')
            ->leftJoin('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.id', 'produk.nama', 'produk.sku', 'produk.stok', 'produk.stok_ditahan', 'kategori.nama as kategori_nama')
            ->where('produk.nama', 'like', '%' . $this->cari . '%')
            ->paginate(10);

        $mutasiTerbaru = DB::table('mutasi_stok')
            ->join('produk', 'mutasi_stok.produk_id', '=', 'produk.id')
            ->leftJoin('pengguna', 'mutasi_stok.oleh_pengguna_id', '=', 'pengguna.id')
            ->select('mutasi_stok.*', 'produk.nama as produk_nama', 'pengguna.nama as aktor')
            ->latest('created_at')
            ->take(10)
            ->get();

        return view('livewire.admin.stok.manajemen-stok', [
            'stokGlobal' => $stokGlobal,
            'mutasiTerbaru' => $mutasiTerbaru,
            'daftarGudang' => DB::table('gudang')->get()
        ])->layout('components.layouts.admin');
    }

    public function bukaMutasi($id)
    {
        $this->produkTerpilihId = $id;
        $this->dispatch('open-slide-over', id: 'panel-mutasi');
    }
}
