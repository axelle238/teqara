<?php

namespace App\Livewire;

use App\Models\AlamatPengiriman;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\LogAktivitas;
use App\Models\Pesanan;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Checkout extends Component
{
    // Alamat State
    public $alamatTerpilihId = null;
    public $alamat_baru = false;
    public $alamat_pengiriman = '';

    // Pengiriman State
    public $metodePengiriman = 'standar';
    public $biayaPengiriman = 15000;

    // Voucher & Poin State
    public $kodeVoucherInput = '';
    public $voucherTerpakai = null;
    public $nilaiPotonganVoucher = 0;
    
    public $gunakanPoin = false;
    public $poinDiterapkan = 0;
    public $nilaiPotonganPoin = 0;

    public $catatan = '';

    public function mount()
    {
        $keranjangCount = Keranjang::where('pengguna_id', auth()->id())->count();
        if ($keranjangCount === 0) {
            return redirect()->to('/keranjang');
        }

        // Set alamat utama jika ada
        $alamatUtama = AlamatPengiriman::where('pengguna_id', auth()->id())->where('is_utama', true)->first();
        if ($alamatUtama) {
            $this->alamatTerpilihId = $alamatUtama->id;
            $this->alamat_pengiriman = $alamatUtama->alamat_lengkap;
        }
    }

    public function getDaftarAlamatProperty()
    {
        return AlamatPengiriman::where('pengguna_id', auth()->id())->get();
    }

    public function pilihAlamat($id)
    {
        $this->alamatTerpilihId = $id;
        $alamat = AlamatPengiriman::find($id);
        $this->alamat_pengiriman = $alamat->alamat_lengkap;
        $this->alamat_baru = false;
    }

    public function setMetodePengiriman($metode)
    {
        $this->metodePengiriman = $metode;
        $this->biayaPengiriman = match($metode) {
            'ekspres' => 35000,
            'prioritas' => 75000,
            default => 15000,
        };
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
            return $item->produk->harga_jual * $item->jumlah;
        });
    }

    public function togglePoin()
    {
        if ($this->gunakanPoin) {
            $poinUser = auth()->user()->poin_loyalitas ?? 0;
            // Limit poin yang bisa dipakai (maks 50% dari subtotal)
            $maksPoinBisaPakai = ($this->subtotal * 0.5); 
            $this->poinDiterapkan = min($poinUser, $maksPoinBisaPakai);
            $this->nilaiPotonganPoin = $this->poinDiterapkan; // 1 Poin = 1 Rupiah
        } else {
            $this->poinDiterapkan = 0;
            $this->nilaiPotonganPoin = 0;
        }
    }

    public function terapkanVoucher()
    {
        $this->reset(['voucherTerpakai', 'nilaiPotonganVoucher']);

        if (empty($this->kodeVoucherInput)) {
            return;
        }

        $voucher = Voucher::where('kode', $this->kodeVoucherInput)->first();

        if (! $voucher) {
            $this->addError('kodeVoucherInput', 'Kode voucher tidak valid.');
            return;
        }

        if ($voucher->kuota <= 0 || now() < $voucher->berlaku_mulai || now() > $voucher->berlaku_sampai) {
            $this->addError('kodeVoucherInput', 'Voucher tidak dapat digunakan.');
            return;
        }

        if ($this->subtotal < $voucher->min_pembelian) {
            $this->addError('kodeVoucherInput', 'Min. belanja tidak terpenuhi.');
            return;
        }

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
        $this->nilaiPotonganVoucher = $potongan;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Voucher berhasil diterapkan!']);
    }

    public function hapusVoucher()
    {
        $this->reset(['kodeVoucherInput', 'voucherTerpakai', 'nilaiPotonganVoucher']);
    }

    public function getTotalBayarProperty()
    {
        $total = $this->subtotal + $this->biayaPengiriman - $this->nilaiPotonganVoucher - $this->nilaiPotonganPoin;
        return max(0, $total);
    }

    public function buatPesanan()
    {
        $this->validate([
            'alamat_pengiriman' => 'required|min:10',
        ]);

        try {
            DB::beginTransaction();

            $nomorInvoice = 'TRX-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));

            $pesanan = Pesanan::create([
                'nomor_faktur' => $nomorInvoice,
                'pengguna_id' => auth()->id(),
                'total_harga' => $this->totalBayar,
                'potongan_diskon' => $this->nilaiPotonganVoucher + $this->nilaiPotonganPoin,
                'kode_voucher' => $this->voucherTerpakai ? $this->voucherTerpakai->kode : null,
                'biaya_pengiriman' => $this->biayaPengiriman,
                'metode_pengiriman' => $this->metodePengiriman,
                'status_pembayaran' => 'belum_dibayar',
                'status_pesanan' => 'menunggu',
                'alamat_pengiriman' => $this->alamat_pengiriman,
                'catatan' => $this->catatan,
            ]);

            foreach ($this->items as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'harga_saat_ini' => $item->produk->harga_jual,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga_jual * $item->jumlah,
                ]);
            }

            // Integrasi Stok & Poin
            (new \App\Services\LayananStok)->tahanStok($pesanan);

            if ($this->voucherTerpakai) {
                $this->voucherTerpakai->decrement('kuota');
            }

            if ($this->gunakanPoin && $this->poinDiterapkan > 0) {
                auth()->user()->decrement('poin_loyalitas', $this->poinDiterapkan);
                \App\Models\RiwayatPoin::create([
                    'pengguna_id' => auth()->id(),
                    'jumlah' => -$this->poinDiterapkan,
                    'sumber' => 'pembelian',
                    'referensi_id' => $nomorInvoice,
                    'keterangan' => 'Penggunaan poin untuk potongan belanja',
                ]);
            }

            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi' => 'buat_pesanan',
                'target' => $nomorInvoice,
                'pesan_naratif' => "Pesanan {$nomorInvoice} berhasil dibuat dengan metode pengiriman ".strtoupper($this->metodePengiriman),
                'waktu' => now(),
            ]);

            Keranjang::where('pengguna_id', auth()->id())->delete();

            DB::commit();

            $this->dispatch('update-keranjang');
            return redirect()->to('/pesanan/bayar/'.$nomorInvoice);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal: '.$e->getMessage()]);
        }
    }

    #[Title('Otorisasi Checkout - Teqara')]
    public function render()
    {
        return view('livewire.checkout')
            ->layout('components.layouts.app');
    }
}
