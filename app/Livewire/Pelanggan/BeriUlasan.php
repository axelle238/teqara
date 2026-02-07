<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class BeriUlasan extends Component
{
    use WithFileUploads;

    public $produk;
    public $pesanan;
    public $rating = 5;
    public $komentar;
    public $foto = [];

    public function mount($pesananId, $produkId)
    {
        $this->pesanan = Pesanan::where('id', $pesananId)
            ->where('pengguna_id', auth()->id())
            ->where('status_pesanan', 'selesai')
            ->firstOrFail();

        $this->produk = Produk::findOrFail($produkId);

        // Check if reviewed
        $sudahUlas = Ulasan::where('pesanan_id', $this->pesanan->id)
            ->where('produk_id', $this->produk->id)
            ->exists();

        if ($sudahUlas) {
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Anda sudah mengulas produk ini.']);
            return redirect()->route('pesanan.riwayat');
        }
    }

    public function simpanUlasan()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|min:10',
            'foto.*' => 'image|max:2048', 
        ]);

        $urls = [];
        foreach ($this->foto as $f) {
            $path = $f->store('ulasan', 'public');
            $urls[] = '/storage/' . $path;
        }

        Ulasan::create([
            'pengguna_id' => auth()->id(),
            'produk_id' => $this->produk->id,
            'pesanan_id' => $this->pesanan->id,
            'rating' => $this->rating,
            'komentar' => $this->komentar,
            'foto_ulasan' => $urls, // Cast to array in model
            'status' => 'aktif',
        ]);

        // Update Product Rating
        $rataRata = Ulasan::where('produk_id', $this->produk->id)->avg('rating');
        $this->produk->update(['rating_rata_rata' => $rataRata]);

        // Gamification Reward
        $poin = 50; // Base reward
        if (count($urls) > 0) $poin += 50; // Bonus for photo
        if (strlen($this->komentar) > 100) $poin += 25; // Bonus for detailed review

        auth()->user()->increment('poin_loyalitas', $poin);
        \App\Models\RiwayatPoin::create([
            'pengguna_id' => auth()->id(),
            'jumlah' => $poin,
            'keterangan' => 'Reward Ulasan Produk: ' . $this->produk->nama,
            'referensi_id' => $this->pesanan->nomor_faktur
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Ulasan terkirim! +{$poin} Poin ditambahkan."]);
        return redirect()->route('pesanan.riwayat');
    }

    #[Title('Tulis Ulasan - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.beri-ulasan')
            ->layout('components.layouts.app');
    }
}