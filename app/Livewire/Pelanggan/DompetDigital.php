<?php

namespace App\Livewire\Pelanggan;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DompetDigital extends Component
{
    use WithPagination;

    public $filter = 'semua';
    public $showBalance = true;

    public function toggleBalance()
    {
        $this->showBalance = !$this->showBalance;
    }

    public function setFilter($tipe)
    {
        $this->filter = $tipe;
        $this->resetPage(); // Reset pagination if real DB
    }

    public function topUp()
    {
        // In real enterprise app, this creates a TopUp Transaction and redirects to Payment Gateway
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Mengalihkan ke Gerbang Pembayaran...']);
        // return redirect()->route('payment.gateway'); 
    }

    public function getSaldoProperty()
    {
        // Mock balance. In real app: auth()->user()->wallet_balance
        return 1500000;
    }

    public function getRiwayatTransaksiProperty()
    {
        // Mock Data with Filtering
        $data = collect([
            [
                'id' => 'TRX-998811',
                'tipe' => 'masuk',
                'keterangan' => 'Top Up Saldo (BCA)',
                'jumlah' => 500000,
                'status' => 'berhasil',
                'tanggal' => now()->subDays(1)
            ],
            [
                'id' => 'TRX-776622',
                'tipe' => 'keluar',
                'keterangan' => 'Pembayaran Invoice #INV-2026-001',
                'jumlah' => 250000,
                'status' => 'berhasil',
                'tanggal' => now()->subDays(3)
            ],
             [
                'id' => 'TRX-554433',
                'tipe' => 'masuk',
                'keterangan' => 'Pengembalian Dana (Refund)',
                'jumlah' => 1250000,
                'status' => 'berhasil',
                'tanggal' => now()->subDays(5)
            ],
            [
                'id' => 'TRX-332211',
                'tipe' => 'keluar',
                'keterangan' => 'Pembelian Aset Digital',
                'jumlah' => 150000,
                'status' => 'pending',
                'tanggal' => now()->subDays(6)
            ]
        ]);

        if ($this->filter === 'masuk') {
            return $data->where('tipe', 'masuk');
        } elseif ($this->filter === 'keluar') {
            return $data->where('tipe', 'keluar');
        }

        return $data;
    }

    #[Title('Dompet Digital Enterprise - Teqara')]
    public function render()
    {
        return view('livewire.pelanggan.dompet-digital', [
            'transaksi' => $this->riwayatTransaksi
        ])->layout('components.layouts.app');
    }
}
