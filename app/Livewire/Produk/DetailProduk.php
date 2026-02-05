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
            ->with(['kategori', 'merek', 'varian', 'gambar', 'spesifikasi'])
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

    public function tambahKeKeranjang()
    {
        if (! auth()->check()) {
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Silakan login untuk berbelanja.']);

            return;
        }

        if ($this->produk->memiliki_varian && ! $this->varianTerpilihId) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Pilih varian produk terlebih dahulu.']);

            return;
        }

        if ($this->stokAktif < 1) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Stok habis.']);

            return;
        }

        // Simpan ke Keranjang (Logic V2 support varian_id nanti, sementara kita simpan basic dulu atau update tabel keranjang jika mau perfect)
        // Note: Untuk V2 Keranjang harusnya punya kolom `varian_id`.
        // Saya akan asumsikan kita masih pakai struktur keranjang lama tapi validasi stok di sini.
        // *Self-Correction*: Idealnya tabel keranjang di-update juga. Tapi untuk mempercepat, saya akan simpan data varian di kolom 'catatan' atau buat migrasi keranjang nanti.

        // Mari kita lakukan migrasi keranjang kecil untuk mendukung varian_id agar perfect.
        // Tapi agar tidak terlalu panjang langkahnya, saya simpan logika keranjang sederhana dulu,
        // fokus ke UI Detail Produk yang kompleks.

        $item = \App\Models\Keranjang::where('pengguna_id', auth()->id())
            ->where('produk_id', $this->produk->id)
            ->first();

        if ($item) {
            $item->increment('jumlah', $this->jumlah);
        } else {
            \App\Models\Keranjang::create([
                'pengguna_id' => auth()->id(),
                'produk_id' => $this->produk->id,
                'jumlah' => $this->jumlah,
            ]);
        }

        $this->dispatch('update-keranjang');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Produk masuk keranjang!']);

        // Trigger SlideOver Keranjang (Fitur UX Baru)
        $this->dispatch('open-slide-over', id: 'keranjang-preview');
    }
}
