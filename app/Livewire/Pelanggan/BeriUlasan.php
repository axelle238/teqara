<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Livewire\Attributes\Title;

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

        // Cek apakah sudah pernah mengulas di pesanan ini
        $sudahUlas = Ulasan::where('pesanan_id', $this->pesanan->id)
            ->where('produk_id', $this->produk->id)
            ->exists();

        if ($sudahUlas) {
            session()->flash('pesan', 'Anda sudah mengulas produk ini.');
            return redirect()->to('/pesanan/riwayat');
        }
    }

    public function simpanUlasan()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|min:10',
            'foto.*' => 'image|max:2048', // Max 2MB per foto
        ]);

        $urls = [];
        foreach ($this->foto as $f) {
            // Di production: $f->store('ulasan', 'public');
            $urls[] = $f->temporaryUrl(); 
        }

        Ulasan::create([
            'pengguna_id' => auth()->id(),
            'produk_id' => $this->produk->id,
            'pesanan_id' => $this->pesanan->id,
            'rating' => $this->rating,
            'komentar' => $this->komentar,
            'foto_ulasan' => $urls
        ]);

        // Update Rating Produk
        $rataRata = Ulasan::where('produk_id', $this->produk->id)->avg('rating');
        $this->produk->update(['rating_rata_rata' => $rataRata]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Terima kasih atas ulasan Anda!']);
        return redirect()->to('/produk/' . $this->produk->slug);
    }

    #[Title('Tulis Ulasan - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.beri-ulasan')
            ->layout('components.layouts.app');
    }
}
