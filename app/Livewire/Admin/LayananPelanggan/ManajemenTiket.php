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
 */
class ManajemenTiket extends Component
{
    use WithPagination;

    public $filterStatus = ''; // Default semua

    public $tiketTerpilih;

    public $pesanBaru;

    public function bukaTiket($id)
    {
        $this->tiketTerpilih = TiketBantuan::with('pengguna')->findOrFail($id);
        $this->dispatch('open-panel-detail-tiket');
    }

    public function kirimBalasan()
    {
        $this->validate(['pesanBaru' => 'required|min:2']);

        $riwayat = $this->tiketTerpilih->riwayat_pesan ?? [];
        $riwayat[] = [
            'pengirim' => 'admin',
            'nama' => auth()->user()->nama,
            'pesan' => $this->pesanBaru,
            'waktu' => now()->format('Y-m-d H:i:s'),
        ];

        $this->tiketTerpilih->update([
            'riwayat_pesan' => $riwayat,
            'status' => 'diproses', // Otomatis ubah ke diproses jika admin membalas
        ]);

        $this->pesanBaru = '';

        LogHelper::catat('balas_tiket', "Tiket #{$this->tiketTerpilih->id}", 'Admin membalas tiket bantuan.');
    }

    public function ubahStatus($status)
    {
        if ($this->tiketTerpilih) {
            $this->tiketTerpilih->update(['status' => $status]);
            $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Status tiket diubah menjadi '.strtoupper($status)]);
        }
    }

    #[Title('Helpdesk & Tiket - Admin Teqara')]
    public function render()
    {
        // Ambil tiket dikelompokkan untuk Kanban View sederhana (atau list filter)
        // Kita gunakan list filter dulu agar rapi
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
