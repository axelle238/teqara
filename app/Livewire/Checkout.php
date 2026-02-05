<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Voucher;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;

class Checkout extends Component
{
    public $alamat_pengiriman = '';
    public $catatan = '';
    
    // Voucher State
    public $kodeVoucherInput = '';
    public $voucherTerpakai = null;
    public $nilaiPotongan = 0;

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

    public function getSubtotalProperty()
    {
        return $this->items->sum(function ($item) {
            // Hitung harga dasar + tambahan varian (logic sederhana: pakai harga jual base dulu)
            // Idealnya keranjang simpan harga snapshot varian.
            return $item->produk->harga_jual * $item->jumlah;
        });
    }

    public function getTotalBayarProperty()
    {
        return max(0, $this->subtotal - $this->nilaiPotongan);
    }

    public function terapkanVoucher()
    {
        $this->reset(['voucherTerpakai', 'nilaiPotongan']);
        
        if (empty($this->kodeVoucherInput)) return;

        $voucher = Voucher::where('kode', $this->kodeVoucherInput)->first();

        // Validasi Voucher
        if (!$voucher) {
            $this->addError('kodeVoucherInput', 'Kode voucher tidak ditemukan.');
            return;
        }

        if ($voucher->kuota <= 0) {
            $this->addError('kodeVoucherInput', 'Kuota voucher telah habis.');
            return;
        }

        if (now() < $voucher->berlaku_mulai || now() > $voucher->berlaku_sampai) {
            $this->addError('kodeVoucherInput', 'Voucher tidak berlaku saat ini.');
            return;
        }

        if ($this->subtotal < $voucher->min_pembelian) {
            $this->addError('kodeVoucherInput', 'Min. belanja Rp ' . number_format($voucher->min_pembelian, 0, ',', '.') . ' untuk pakai voucher ini.');
            return;
        }

        // Hitung Potongan
        $potongan = 0;
        if ($voucher->tipe_diskon == 'nominal') {
            $potongan = $voucher->nilai_diskon;
        } else {
            $potongan = $this->subtotal * ($voucher->nilai_diskon / 100);
            if ($voucher->maks_potongan && $potongan > $voucher->maks_potongan) {
                $potongan = $voucher->maks_potongan;
            }
        }

        $this->voucherTerpakai = $voucher;
        $this->nilaiPotongan = $potongan;

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Voucher berhasil diterapkan! Hemat Rp ' . number_format($potongan, 0, ',', '.')]);
    }

    public function hapusVoucher()
    {
        $this->reset(['kodeVoucherInput', 'voucherTerpakai', 'nilaiPotongan']);
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
            $nomorInvoice = 'TRX-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            // 2. Buat Pesanan
            $pesanan = Pesanan::create([
                'nomor_invoice' => $nomorInvoice,
                'pengguna_id' => auth()->id(),
                'total_harga' => $this->totalBayar, // Total setelah diskon
                'potongan_diskon' => $this->nilaiPotongan,
                'kode_voucher' => $this->voucherTerpakai ? $this->voucherTerpakai->kode : null,
                'status_pembayaran' => 'belum_dibayar',
                'status_pesanan' => 'menunggu',
                'alamat_pengiriman' => $this->alamat_pengiriman,
            ]);

            // 3. Pindahkan item & Kurangi Stok
            foreach ($this->items as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'harga_saat_ini' => $item->produk->harga_jual,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga_jual * $item->jumlah,
                ]);

                $produk = Produk::find($item->produk_id);
                if ($produk->stok < $item->jumlah) {
                    throw new \Exception("Stok produk {$produk->nama} tidak mencukupi.");
                }
                $produk->decrement('stok', $item->jumlah);
            }

            // 4. Update Kuota Voucher
            if ($this->voucherTerpakai) {
                $this->voucherTerpakai->decrement('kuota');
            }

            // 5. Catat Log
            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi' => 'buat_pesanan',
                'target' => $nomorInvoice,
                'pesan_naratif' => "Pelanggan " . auth()->user()->nama . " membuat pesanan {$nomorInvoice}. Total: " . number_format($this->totalBayar, 0, ',', '.'),
                'waktu' => now()
            ]);

            // 6. Bersihkan Keranjang
            Keranjang::where('pengguna_id', auth()->id())->delete();

            DB::commit();

            $this->dispatch('update-keranjang');
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Pesanan #{$nomorInvoice} berhasil dibuat!"]);

            return redirect()->to('/pesanan/bayar/' . $nomorInvoice);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    #[Title('Checkout - Teqara')]
    public function render()
    {
        return view('livewire.checkout')
            ->layout('components.layouts.app');
    }
}