<?php

namespace App\Livewire\Admin\LayananPelanggan;

use App\Helpers\LogHelper;
use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ManajemenTiket
 * Tujuan: Manajemen tiket bantuan dan keluhan pelanggan.
 * Arsitektur: 100% Full Page SPA (Tanpa Slide Over/Modal).
 */
class ManajemenTiket extends Component
{
    use WithPagination;

    // State Halaman
    public $tampilkanDetail = false;

    // Filter
    public $filterStatus = '';

    // Properti Model
    public $tiketTerpilih;
    public $pesanBaru;

    /**
     * Buka detail tiket dalam tampilan halaman penuh.
     */
    public function bukaTiket($id)
    {
        $this->tiketTerpilih = TiketBantuan::with('pengguna')->findOrFail($id);
        $this->tampilkanDetail = true;
    }

    /**
     * Kembali ke daftar tiket utama.
     */
    public function kembali()
    {
        $this->tampilkanDetail = false;
        $this->reset(['tiketTerpilih', 'pesanBaru']);
    }

    /**
     * Mengirim balasan administratif ke tiket pelanggan.
     */
    public function kirimBalasan()
    {
        $this->validate([
            'pesanBaru' => 'required|min:2'
        ], [
            'pesanBaru.required' => 'Pesan balasan tidak boleh kosong.',
            'pesanBaru.min' => 'Pesan terlalu singkat.',
        ]);

        $riwayat = $this->tiketTerpilih->riwayat_pesan ?? [];
        $riwayat[] = [
            'pengirim' => 'admin',
            'nama' => auth()->user()->nama,
            'pesan' => $this->pesanBaru,
            'waktu' => now()->format('Y-m-d H:i:s'),
        ];

        $this->tiketTerpilih->update([
            'riwayat_pesan' => $riwayat,
            'status' => 'diproses',
        ]);

        $this->pesanBaru = '';
        $this->tiketTerpilih->refresh();

        LogHelper::catat('balas_tiket', "Tiket #{$this->tiketTerpilih->id}", 'Admin memberikan respon solusi pada tiket bantuan.');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Balasan terkirim secara real-time.']);
    }

    /**
     * Mengubah status resolusi tiket.
     */
    public function ubahStatus($status)
    {
        if ($this->tiketTerpilih) {
            $this->tiketTerpilih->update(['status' => $status]);
            $this->tiketTerpilih->refresh();
            
            $pesan = 'Status tiket diubah menjadi '.strtoupper($status);
            LogHelper::catat('status_tiket', "Tiket #{$this->tiketTerpilih->id}", $pesan);
            $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => $pesan]);
        }
    }

    #[Title('Pusat Bantuan Enterprise - Teqara')]
    public function render()
    {
        $query = TiketBantuan::with('pengguna')->latest();

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.layanan-pelanggan.manajemen-tiket', [
            'daftarTiket' => $query->paginate(10),
            'statistik' => [
                'terbuka' => TiketBantuan::where('status', 'terbuka')->count(),
                'diproses' => TiketBantuan::where('status', 'diproses')->count(),
                'selesai' => TiketBantuan::where('status', 'selesai')->count(),
            ],
        ])->layout('components.layouts.admin');
    }
}