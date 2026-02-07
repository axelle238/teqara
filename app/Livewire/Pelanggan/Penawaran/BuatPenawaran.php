<?php

namespace App\Livewire\Pelanggan\Penawaran;

use App\Models\PenawaranHarga;
use App\Models\Produk;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuatPenawaran extends Component
{
    use WithFileUploads;

    public $items = []; // [{produk_id, jumlah, catatan}]
    public $pesan;
    public $lampiran;

    public function mount()
    {
        // Inisialisasi satu item kosong
        $this->tambahItem();
    }

    public function tambahItem()
    {
        $this->items[] = ['produk_id' => '', 'jumlah' => 1, 'catatan' => ''];
    }

    public function hapusItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function getDaftarProdukProperty()
    {
        return Produk::where('status', 'aktif')->orderBy('nama')->get();
    }

    public function ajukan()
    {
        $this->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produk,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'pesan' => 'nullable|string',
            'lampiran' => 'nullable|file|max:5120', // 5MB
        ]);

        $path = null;
        if ($this->lampiran) {
            $path = $this->lampiran->store('penawaran', 'public');
        }

        // Hitung estimasi total awal (berdasarkan harga normal)
        $totalEstimasi = 0;
        foreach ($this->items as $item) {
            $produk = Produk::find($item['produk_id']);
            $totalEstimasi += $produk->harga_jual * $item['jumlah'];
        }

        $rfq = PenawaranHarga::create([
            'pengguna_id' => auth()->id(),
            'status' => 'menunggu',
            'total_pengajuan' => $totalEstimasi,
            'pesan_user' => $this->pesan,
            'file_lampiran' => $path ? '/storage/' . $path : null,
        ]);

        foreach ($this->items as $item) {
            $rfq->items()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
                // harga_tawar_satuan dikosongkan, biarkan admin yang isi/approve
            ]);
        }

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Permintaan penawaran berhasil dikirim.']);
        return redirect()->route('customer.rfq.index');
    }

    #[Title('Buat RFQ Baru - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.penawaran.buat-penawaran')
            ->layout('components.layouts.app');
    }
}
