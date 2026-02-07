<?php

namespace App\Livewire\Pengelola\ManajemenPesanan;

use App\Helpers\LogHelper;
use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPesanan extends Component
{
    use WithPagination;

    public $filterStatus = 'semua';
    public $cari = '';
    public $tanggalMulai;
    public $tanggalAkhir;

    // Aksi Cepat
    public $inputResi = []; 

    public function updated($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function setStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function prosesPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        if ($pesanan->status_pesanan == 'menunggu') {
            $pesanan->update(['status_pesanan' => 'diproses']);
            LogHelper::catat('proses_pesanan', "Order #{$pesanan->nomor_faktur}", 'Admin memproses pesanan.');
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesanan diproses. Stok telah dikunci.']);
        }
    }

    public function kirimPesanan($id)
    {
        $resi = $this->inputResi[$id] ?? null;
        
        if (empty($resi)) {
            $this->dispatch('notifikasi', ['tipe' => 'error', 'pesan' => 'Nomor resi wajib diisi untuk pengiriman.']);
            return;
        }

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => 'dikirim',
            'resi_pengiriman' => $resi
        ]);

        LogHelper::catat('kirim_pesanan', "Order #{$pesanan->nomor_faktur}", "Pesanan dikirim dengan resi: $resi");
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesanan berhasil dikirim.']);
    }

    public function batalkanPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status_pesanan' => 'dibatalkan']);
        
        // Kembalikan stok
        (new \App\Services\LayananStok)->kembalikanStok($pesanan);

        LogHelper::catat('batal_pesanan', "Order #{$pesanan->nomor_faktur}", 'Admin membatalkan pesanan.');
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Pesanan dibatalkan & stok dikembalikan.']);
    }

    public function getStatistikProperty()
    {
        return [
            'total' => Pesanan::count(),
            'menunggu' => Pesanan::where('status_pesanan', 'menunggu')->count(),
            'diproses' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'dikirim' => Pesanan::where('status_pesanan', 'dikirim')->count(),
            'selesai' => Pesanan::where('status_pesanan', 'selesai')->count(),
        ];
    }

    #[Title('Manajemen Pesanan - Teqara')]
    public function render()
    {
        $query = Pesanan::with(['pengguna', 'detailPesanan'])
            ->latest('dibuat_pada');

        if ($this->filterStatus !== 'semua') {
            $query->where('status_pesanan', $this->filterStatus);
        }

        if ($this->cari) {
            $query->where('nomor_faktur', 'like', '%' . $this->cari . '%')
                  ->orWhereHas('pengguna', function($q) {
                      $q->where('nama', 'like', '%' . $this->cari . '%');
                  });
        }

        return view('livewire.pengelola.manajemen-pesanan.daftar-pesanan', [
            'pesanan' => $query->paginate(10)
        ])->layout('components.layouts.admin', ['header' => 'Pusat Pesanan']);
    }
}
