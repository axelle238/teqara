<?php

namespace App\Livewire\Produk;

use App\Models\Produk;
use App\Models\VarianProduk;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailProduk extends Component
{
    public $produk;

    public $jumlah = 1;

    // State untuk fitur kompleks
    public $varianTerpilihId = null;

    public $hargaAktif;

    public $stokAktif;

    public $gambarAktif;

    public function mount($slug)
    {
        $this->produk = Produk::where('slug', $slug)
            ->with(['kategori', 'merek', 'varian', 'gambar', 'spesifikasi', 'ulasan'])
            ->firstOrFail();

        // Inisialisasi State
        $this->hargaAktif = $this->produk->harga_jual;
        $this->stokAktif = $this->produk->stok;
        $this->gambarAktif = $this->produk->gambar_utama_url;

        // Auto-select varian pertama jika ada
        if ($this->produk->memiliki_varian && $this->produk->varian->count() > 0) {
            $varianPertama = $this->produk->varian->first();
            $this->pilihVarian($varianPertama->id);
        }
    }

    public function pilihVarian($varianId)
    {
        $varian = VarianProduk::find($varianId);
        if ($varian) {
            $this->varianTerpilihId = $varianId;
            $this->hargaAktif = $this->produk->harga_jual + $varian->harga_tambahan;
            $this->stokAktif = $varian->stok;
            $this->jumlah = 1; // Reset jumlah
        }
    }

    public function gantiGambar($url)
    {
        $this->gambarAktif = $url;
    }

    // Enterprise Feature: Cross-selling
    public function getProdukTerkaitProperty()
    {
        return Produk::where('kategori_id', $this->produk->kategori_id)
            ->where('id', '!=', $this->produk->id)
            ->where('status', 'aktif')
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    // Enterprise Feature: Statistik Ulasan
    public function getStatistikRatingProperty()
    {
        $total = $this->produk->ulasan->count();
        if ($total == 0) return [];

        $stats = [
            5 => $this->produk->ulasan->where('rating', 5)->count(),
            4 => $this->produk->ulasan->where('rating', 4)->count(),
            3 => $this->produk->ulasan->where('rating', 3)->count(),
            2 => $this->produk->ulasan->where('rating', 2)->count(),
            1 => $this->produk->ulasan->where('rating', 1)->count(),
        ];

        // Hitung persentase
        foreach ($stats as $bintang => $jumlah) {
            $stats[$bintang] = [
                'jumlah' => $jumlah,
                'persen' => ($jumlah / $total) * 100
            ];
        }

        return $stats;
    }

    public function tambahJumlah()
    {
        if ($this->jumlah < $this->stokAktif) {
            $this->jumlah++;
        }
    }

    public function kurangJumlah()
    {
        if ($this->jumlah > 1) {
            $this->jumlah--;
        }
    }

    private function prosesMasukKeranjang()
    {
        if (! auth()->check()) {
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Silakan login untuk berbelanja.']);
            return false;
        }

        if ($this->produk->memiliki_varian && ! $this->varianTerpilihId) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Pilih varian produk terlebih dahulu.']);
            return false;
        }

        if ($this->stokAktif < 1) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Stok habis.']);
            return false;
        }

        // Logic Keranjang Enterprise
        $item = \App\Models\Keranjang::where('pengguna_id', auth()->id())
            ->where('produk_id', $this->produk->id)
            // Idealnya tambah where 'varian_id'
            ->first();

        if ($item) {
            $item->increment('jumlah', $this->jumlah);
        } else {
            \App\Models\Keranjang::create([
                'pengguna_id' => auth()->id(),
                'produk_id' => $this->produk->id,
                'jumlah' => $this->jumlah,
                // 'varian_id' => $this->varianTerpilihId
            ]);
        }

        return true;
    }

    public function tambahKeKeranjang()
    {
        if ($this->prosesMasukKeranjang()) {
            $this->dispatch('update-keranjang');
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Produk masuk keranjang!']);
            $this->dispatch('open-slide-over', id: 'keranjang-preview');
        }
    }

    public function beliSekarang()
    {
        if ($this->prosesMasukKeranjang()) {
            return redirect()->route('checkout');
        }
    }

    #[Title('Detail Produk')]
    public function render()
    {
        $deskripsi_seo = strip_tags($this->produk->deskripsi_singkat ?? $this->produk->nama);

        return view('livewire.produk.detail-produk')
            ->layout('components.layouts.app', [
                'title' => $this->produk->nama.' | Teqara Enterprise',
                'deskripsi' => $deskripsi_seo,
            ]);
    }
}
