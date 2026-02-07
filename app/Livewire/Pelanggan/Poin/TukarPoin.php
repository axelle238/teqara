<?php

namespace App\Livewire\Pelanggan\Poin;

use App\Models\RiwayatPoin;
use App\Models\Voucher;
use Livewire\Attributes\Title;
use Livewire\Component;

class TukarPoin extends Component
{
    public function getPoinSayaProperty()
    {
        return auth()->user()->poin_loyalitas ?? 0;
    }

    public function getKatalogHadiahProperty()
    {
        // Simulasi hadiah
        return collect([
            ['id' => 1, 'nama' => 'Voucher Rp 50.000', 'poin' => 5000, 'tipe' => 'voucher', 'kode' => 'RWD-50K'],
            ['id' => 2, 'nama' => 'Voucher Rp 100.000', 'poin' => 9500, 'tipe' => 'voucher', 'kode' => 'RWD-100K'],
            ['id' => 3, 'nama' => 'Gratis Ongkir (1x)', 'poin' => 2500, 'tipe' => 'ongkir', 'kode' => 'RWD-FREESHIP'],
            ['id' => 4, 'nama' => 'Merchandise Teqara', 'poin' => 15000, 'tipe' => 'barang', 'kode' => 'MERCH-001'],
        ]);
    }

    public function tukar($hadiahId)
    {
        $hadiah = $this->katalogHadiah->firstWhere('id', $hadiahId);
        
        if ($this->poinSaya < $hadiah['poin']) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Poin tidak mencukupi.']);
            return;
        }

        // Proses penukaran
        auth()->user()->decrement('poin_loyalitas', $hadiah['poin']);
        
        RiwayatPoin::create([
            'pengguna_id' => auth()->id(),
            'jumlah' => -$hadiah['poin'],
            'sumber' => 'penukaran',
            'keterangan' => 'Penukaran poin: ' . $hadiah['nama']
        ]);

        // Simpan voucher ke dompet user (simulasi)
        // ...

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Berhasil ditukar! Cek dompet voucher Anda.']);
    }

    #[Title('Pusat Penukaran Poin - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.poin.tukar-poin')
            ->layout('components.layouts.app');
    }
}
