<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarPesanan
 * Tujuan: Manajemen pusat sirkulasi pesanan (Midstream) Enterprise.
 */
class DaftarPesanan extends Component
{
    use WithPagination;

    // Filter State
    public $status_pesanan = 'semua';
    public $status_pembayaran = '';
    public $cari = '';
    public $rentang_tanggal = '';

    // Bulk Actions State
    public $selectedPesanan = [];
    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPesanan = $this->getQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedPesanan = [];
        }
    }

    public function updatedStatusPesanan()
    {
        $this->resetPage();
        $this->reset(['selectedPesanan', 'selectAll']);
    }

    public function getQuery()
    {
        return Pesanan::query()
            ->with(['pengguna', 'detailPesanan'])
            ->when($this->status_pesanan !== 'semua', fn($q) => $q->where('status_pesanan', $this->status_pesanan))
            ->when($this->status_pembayaran, fn($q) => $q->where('status_pembayaran', $this->status_pembayaran))
            ->when($this->cari, function ($q) {
                $q->where('nomor_faktur', 'like', '%'.$this->cari.'%')
                  ->orWhereHas('pengguna', fn ($p) => $p->where('nama', 'like', '%'.$this->cari.'%'));
            })
            ->latest();
    }

    public function bulkProcess()
    {
        $count = count($this->selectedPesanan);
        if ($count > 0) {
            Pesanan::whereIn('id', $this->selectedPesanan)
                ->where('status_pesanan', 'menunggu')
                ->where('status_pembayaran', 'lunas')
                ->update(['status_pesanan' => 'diproses']);

            LogHelper::catat('proses_massal', 'Admin', "Memproses {$count} pesanan sekaligus.");
            
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "{$count} pesanan diproses ke tahap pengemasan."]);
            $this->reset(['selectedPesanan', 'selectAll']);
        }
    }

    #[Title('Sirkulasi Pesanan - Teqara Admin')]
    public function render()
    {
        // Statistik Real-time untuk Tabs
        $stats = [
            'semua' => Pesanan::count(),
            'menunggu' => Pesanan::where('status_pesanan', 'menunggu')->count(),
            'diproses' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'dikirim' => Pesanan::where('status_pesanan', 'dikirim')->count(),
            'selesai' => Pesanan::where('status_pesanan', 'selesai')->count(),
            'batal' => Pesanan::where('status_pesanan', 'batal')->count(),
        ];

        return view('livewire.pengelola.manajemen-pesanan.daftar-pesanan', [
            'pesanan' => $this->getQuery()->paginate(10),
            'stats' => $stats
        ])->layout('components.layouts.admin');
    }
}
