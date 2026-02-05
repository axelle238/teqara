<?php

namespace App\Livewire;

use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Checkout extends Component
{
    public $alamat_pengiriman = '';

    public $catatan = '';

    public function mount()
    {
        if (Keranjang::where('pengguna_id', auth()->id())->count() === 0) {
            return redirect()->to('/keranjang');
        }
    }

    public function getItemsProperty()
    {
        return Keranjang::where('pengguna_id', auth()->id())
            ->with('produk')
            ->get();
    }

    public function getTotalHargaProperty()
    {
        return $this->items->sum(function ($item) {
            return $item->produk->harga_jual * $item->jumlah;
        });
    }

    public function buatPesanan()
    {
        $this->validate([
            'alamat_pengiriman' => 'required|min:10',
        ], [
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'alamat_pengiriman.min' => 'Alamat pengiriman terlalu pendek (minimal 10 karakter).',
        ]);

        try {
            DB::beginTransaction();

            // 1. Generate Nomor Invoice
            $nomorInvoice = 'TRX-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));

            // 2. Buat Pesanan
            $pesanan = Pesanan::create([
                'nomor_invoice' => $nomorInvoice,
                'pengguna_id' => auth()->id(),
                'total_harga' => $this->total_harga,
                'status_pembayaran' => 'belum_dibayar',
                'status_pesanan' => 'menunggu',
                'alamat_pengiriman' => $this->alamat_pengiriman,
            ]);

            // 3. Pindahkan item & Kurangi Stok
            foreach ($this->items as $item) {
                // Snapshot harga untuk detail pesanan
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'harga_saat_ini' => $item->produk->harga_jual,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga_jual * $item->jumlah,
                ]);

                // Kurangi stok produk
                $produk = Produk::find($item->produk_id);
                if ($produk->stok < $item->jumlah) {
                    throw new \Exception("Stok produk {$produk->nama} tidak mencukupi.");
                }
                $produk->decrement('stok', $item->jumlah);
            }

            // 4. Catat Log Aktivitas
            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi' => 'buat_pesanan',
                'target' => $nomorInvoice,
                'pesan_naratif' => 'Pelanggan '.auth()->user()->nama." berhasil membuat pesanan baru dengan nomor invoice {$nomorInvoice} total Rp ".number_format($this->total_harga, 0, ',', '.'),
            ]);

            // 5. Kosongkan Keranjang
            Keranjang::where('pengguna_id', auth()->id())->delete();

            DB::commit();

            $this->dispatch('update-keranjang');
            $this->dispatch('notifikasi', [
                'tipe' => 'sukses',
                'pesan' => "Pesanan #{$nomorInvoice} berhasil dibuat!",
            ]);

            return redirect()->to('/pesanan/riwayat');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notifikasi', [
                'tipe' => 'error',
                'pesan' => 'Gagal membuat pesanan: '.$e->getMessage(),
            ]);
        }
    }

    #[Title('Checkout - Teqara')]
    public function render()
    {
        return view('livewire.checkout')
            ->layout('components.layouts.app');
    }
}
