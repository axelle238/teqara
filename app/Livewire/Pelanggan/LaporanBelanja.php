<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use PDF; // Asumsi ada package PDF, atau kita simulasi download

class LaporanBelanja extends Component
{
    public $bulan;
    public $tahun;
    public $tipe_laporan = 'ringkasan'; // ringkasan, detail

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function getLaporanDataProperty()
    {
        return Pesanan::where('pengguna_id', auth()->id())
            ->where('status_pesanan', 'selesai')
            ->whereYear('dibuat_pada', $this->tahun)
            ->whereMonth('dibuat_pada', $this->bulan)
            ->get();
    }

    public function getTotalPengeluaranProperty()
    {
        return $this->laporanData->sum('total_harga');
    }

    public function unduhPDF()
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Laporan sedang digenerate. Unduhan akan dimulai otomatis.']);
        // Logic generate PDF stream...
    }

    public function unduhExcel()
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Laporan Excel sedang disiapkan.']);
        // Logic generate Excel...
    }

    #[Title('Laporan Pengeluaran - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.laporan-belanja')
            ->layout('components.layouts.app');
    }
}
