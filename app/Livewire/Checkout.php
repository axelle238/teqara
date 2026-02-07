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
    public $kotaId = null;

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
    
    // Enterprise Options
    public $asuransi = false;
    public $dropship = false;
    public $dropship_nama = '';
    public $dropship_telepon = '';

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
            $this->kotaId = $alamatUtama->kota_id;
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
        $this->kotaId = $alamat->kota_id;
        $this->alamat_baru = false;
        
        $this->metodePengiriman = 'standar';
        $this->biayaPengiriman = 15000;
    }

    public function getTotalBeratProperty()
    {
        // Mock weight: 500g per item if not set
        return $this->items->sum(function($item) {
            $beratSatuan = $item->produk->berat_gram ?? 500;
            return $beratSatuan * $item->jumlah;
        });
    }

    public function getAvailableShippingMethodsProperty()
    {
        $settings = \App\Models\PengaturanSistem::pluck('nilai', 'kunci');
        $methods = [];
        $totalWeight = $this->totalBerat;

        // RajaOngkir Integrated
        if (!empty($settings['logistic_rajaongkir_key']) && $this->kotaId) {
            $layanan = new \App\Services\LayananLogistik();
            
            // Fetch for common couriers (Starter supports jne, pos, tiki)
            $couriers = ['jne', 'pos', 'tiki'];
            if ($settings['logistic_rajaongkir_type'] !== 'starter') {
                $couriers = ['jne', 'pos', 'tiki', 'jnt', 'sicepat', 'anteraja'];
            }

            foreach ($couriers as $courier) {
                try {
                    $costs = $layanan->hitungBiaya($this->kotaId, $totalWeight, $courier);
                    foreach ($costs as $c) {
                        $key = $c['code'] . '_' . strtolower(str_replace(' ', '_', $c['service']));
                        $methods[$key] = [
                            'name' => $c['name'],
                            'cost' => $c['cost'],
                            'etd' => $c['etd'] . ' Hari',
                            'logo' => null // Bisa ditambahkan mapping logo kurir jika perlu
                        ];
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("RajaOngkir Error for {$courier}: " . $e->getMessage());
                }
            }
        } 
        
        // Always provide fallback/manual if results are empty
        if (empty($methods)) {
            $totalKg = ceil($totalWeight / 1000);
            $methods['standar'] = [
                'name' => 'Standar Toko',
                'cost' => 15000 * $totalKg,
                'etd' => '3-5 Hari',
                'logo' => null
            ];
            $methods['ekspres'] = [
                'name' => 'Ekspres Toko',
                'cost' => 35000 * $totalKg,
                'etd' => '1-2 Hari',
                'logo' => null
            ];
        }

        return $methods;
    }

    public function setMetodePengiriman($metode)
    {
        $methods = $this->availableShippingMethods;
        
        if (isset($methods[$metode])) {
            $this->metodePengiriman = $metode;
            $this->biayaPengiriman = $methods[$metode]['cost'];
        }
    }

    public function getItemsProperty()
    {
        return Keranjang::where('pengguna_id', auth()->id())
            ->with(['produk', 'varian'])
            ->get();
    }

    public function getSubtotalProperty()
    {
        return $this->items->sum(function ($item) {
            return $item->subtotal;
        });
    }

    public function getBiayaAsuransiProperty()
    {
        return $this->asuransi ? ($this->subtotal * 0.005) : 0; // 0.5% insurance fee
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

    // ... (kode voucher tetap sama, tidak perlu diubah di sini karena pakai tool replace)

    public function getTotalBayarProperty()
    {
        $total = $this->subtotal + $this->biayaPengiriman + $this->biayaAsuransi - $this->nilaiPotonganVoucher - $this->nilaiPotonganPoin;
        return max(0, $total);
    }

    public function buatPesanan()
    {
        $this->validate([
            'alamat_pengiriman' => 'required|min:10',
            'dropship_nama' => 'required_if:dropship,true',
            'dropship_telepon' => 'required_if:dropship,true',
        ]);

        if ($this->items->isEmpty()) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Keranjang belanja kosong.']);
            return;
        }

        try {
            DB::beginTransaction();

            $nomorInvoice = 'TRX-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));

            // Catatan Tambahan
            $finalCatatan = $this->catatan;
            if ($this->dropship) {
                $finalCatatan .= "\n[DROPSHIP] Pengirim: {$this->dropship_nama} ({$this->dropship_telepon})";
            }
            if ($this->asuransi) {
                $finalCatatan .= "\n[ASURANSI] Paket Diasuransikan.";
            }

            // 1. Buat Header Pesanan
            $pesanan = Pesanan::create([
                'nomor_faktur' => $nomorInvoice,
                'pengguna_id' => auth()->id(),
                'total_harga' => $this->totalBayar,
                'potongan_diskon' => $this->nilaiPotonganVoucher + $this->nilaiPotonganPoin,
                'kode_voucher' => $this->voucherTerpakai ? $this->voucherTerpakai->kode : null,
                'biaya_pengiriman' => $this->biayaPengiriman + $this->biayaAsuransi, // Include insurance in shipping cost for simplicity
                'metode_pengiriman' => $this->metodePengiriman,
                'status_pembayaran' => 'belum_dibayar',
                'status_pesanan' => 'menunggu',
                'alamat_pengiriman' => $this->alamat_pengiriman,
                'catatan' => $finalCatatan,
            ]);

            // 2. Pindahkan Item Keranjang ke Detail Pesanan
            foreach ($this->items as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'varian_id' => $item->varian_id, // Penting untuk tracking varian
                    'harga_saat_ini' => $item->harga_satuan, // Snapshot harga saat transaksi terjadi
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // 3. Integrasi Sistem Stok (Hold Stock)
            (new \App\Services\LayananStok)->tahanStok($pesanan);

            // 4. Update Kuota Voucher
            if ($this->voucherTerpakai) {
                $this->voucherTerpakai->decrement('kuota');
            }

            // 5. Deduksi Poin Loyalitas
            if ($this->gunakanPoin && $this->poinDiterapkan > 0) {
                $user = auth()->user();
                if ($user->poin_loyalitas >= $this->poinDiterapkan) {
                    $user->decrement('poin_loyalitas', $this->poinDiterapkan);
                    \App\Models\RiwayatPoin::create([
                        'pengguna_id' => $user->id,
                        'jumlah' => -$this->poinDiterapkan,
                        'sumber' => 'pembelian',
                        'referensi_id' => $nomorInvoice,
                        'keterangan' => 'Redeem poin untuk Order #' . $nomorInvoice,
                    ]);
                }
            }

            // 6. Catat Log Audit
            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi' => 'buat_pesanan',
                'target' => $nomorInvoice,
                'pesan_naratif' => "Pesanan {$nomorInvoice} dibuat. Total: Rp " . number_format($this->totalBayar, 0, ',', '.'),
                'waktu' => now(),
            ]);

            // 7. Bersihkan Keranjang
            Keranjang::where('pengguna_id', auth()->id())->delete();

            DB::commit();

            $this->dispatch('keranjang-diperbarui'); // Update badge navbar
            
            // Redirect ke halaman pembayaran
            return redirect()->to('/pesanan/bayar/'.$nomorInvoice);

        } catch (\Exception $e) {
            DB::rollBack();
            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi' => 'gagal_pesanan',
                'target' => 'Checkout',
                'pesan_naratif' => 'Gagal checkout: ' . $e->getMessage(),
                'waktu' => now(),
            ]);
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Gagal memproses pesanan: '.$e->getMessage()]);
        }
    }

    #[Title('Otorisasi Checkout - Teqara')]
    public function render()
    {
        return view('livewire.checkout')
            ->layout('components.layouts.app');
    }
}
