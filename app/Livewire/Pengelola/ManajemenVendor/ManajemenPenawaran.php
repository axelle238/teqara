<?php

namespace App\Livewire\Pengelola\ManajemenVendor;

use App\Helpers\LogHelper;
use App\Models\PenawaranHarga;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenPenawaran extends Component
{
    use WithPagination;

    public $filterStatus = 'semua';
    public $cari = '';

    // Detail/Edit State
    public $tampilkanDetail = false;
    public $penawaranTerpilih;
    public $pesanAdmin;
    public $hargaTawar = []; // [item_id => harga]

    public function setStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function lihatDetail($id)
    {
        $this->penawaranTerpilih = PenawaranHarga::with(['pengguna', 'items.produk'])->findOrFail($id);
        $this->pesanAdmin = $this->penawaranTerpilih->pesan_admin;
        
        foreach ($this->penawaranTerpilih->items as $item) {
            $this->hargaTawar[$item->id] = $item->harga_tawar_satuan ?? $item->produk->harga_jual;
        }

        $this->tampilkanDetail = true;
    }

    public function batal()
    {
        $this->tampilkanDetail = false;
        $this->reset(['penawaranTerpilih', 'pesanAdmin', 'hargaTawar']);
    }

    public function kirimPenawaran()
    {
        $this->validate([
            'pesanAdmin' => 'required|min:5',
            'hargaTawar.*' => 'required|numeric|min:0',
        ]);

        $totalTawar = 0;
        foreach ($this->hargaTawar as $itemId => $harga) {
            $item = $this->penawaranTerpilih->items()->find($itemId);
            if ($item) {
                $item->update(['harga_tawar_satuan' => $harga]);
                $totalTawar += $harga * $item->jumlah;
            }
        }

        $this->penawaranTerpilih->update([
            'status' => 'dibalas',
            'pesan_admin' => $this->pesanAdmin,
            'total_pengajuan' => $totalTawar, // Update total berdasarkan tawaran baru
            'diperbarui_pada' => now()
        ]);

        LogHelper::catat('balas_rfq', "RFQ #{$this->penawaranTerpilih->id}", "Admin mengirimkan penawaran harga khusus ke pelanggan.");
        
        $this->tampilkanDetail = false;
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Penawaran harga berhasil dikirim ke pelanggan.']);
    }

    #[Title('Manajemen RFQ & Penawaran - Teqara Admin')]
    public function render()
    {
        $query = PenawaranHarga::with('pengguna')
            ->when($this->filterStatus !== 'semua', fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->cari, function($q) {
                $q->where('id', 'like', '%'.$this->cari.'%')
                  ->orWhereHas('pengguna', fn($u) => $u->where('nama', 'like', '%'.$this->cari.'%'));
            })
            ->latest('dibuat_pada');

        return view('livewire.pengelola.manajemen-vendor.manajemen-penawaran', [
            'daftar_penawaran' => $query->paginate(10)
        ])->layout('components.layouts.admin', ['header' => 'B2B RFQ Hub']);
    }
}
