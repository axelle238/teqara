<?php

namespace App\Livewire\LayananPelanggan;

use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailTiket extends Component
{
    use WithFileUploads;

    public TiketBantuan $tiket;
    public $pesanBaru;
    public $lampiran;

    public function mount($id)
    {
        $this->tiket = TiketBantuan::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->firstOrFail();
    }

    public function kirimPesan()
    {
        $this->validate([
            'pesanBaru' => 'required|min:2',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        $path = null;
        if ($this->lampiran) {
            $path = $this->lampiran->store('tiket-lampiran', 'public');
        }

        // Ambil riwayat pesan lama (JSON)
        $riwayat = $this->tiket->riwayat_pesan ?? [];
        
        // Tambah pesan baru
        $riwayat[] = [
            'pengirim' => 'user', // user atau admin
            'nama' => auth()->user()->nama,
            'pesan' => $this->pesanBaru,
            'waktu' => now()->toIso8601String(),
            'lampiran' => $path ? ['/storage/'.$path] : [],
        ];

        $this->tiket->update([
            'riwayat_pesan' => $riwayat,
            'status' => 'terbuka', // Re-open jika user membalas
            'diperbarui_pada' => now()
        ]);

        $this->reset(['pesanBaru', 'lampiran']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pesan terkirim.']);
    }

    public function tutupTiket()
    {
        $this->tiket->update(['status' => 'selesai']);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Tiket ditutup.']);
    }

    #[Title('Detail Tiket Bantuan - Teqara')]
    public function render()
    {
        return view('livewire.layanan-pelanggan.detail-tiket')
            ->layout('components.layouts.app');
    }
}
