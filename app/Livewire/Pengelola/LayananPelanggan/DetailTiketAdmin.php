<?php

namespace App\Livewire\Pengelola\LayananPelanggan;

use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailTiketAdmin extends Component
{
    use WithFileUploads;

    public $tiketId;
    public $tiket;
    public $pesanBaru;
    public $lampiran;
    public $statusBaru;
    public $prioritasBaru;

    public function mount($id)
    {
        $this->tiketId = $id;
        $this->loadTiket();
    }

    public function loadTiket()
    {
        $this->tiket = TiketBantuan::with('pengguna')->findOrFail($this->tiketId);
        $this->statusBaru = $this->tiket->status;
        $this->prioritasBaru = $this->tiket->prioritas;
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

        $riwayat = $this->tiket->riwayat_pesan ?? [];
        $riwayat[] = [
            'pengirim' => 'admin',
            'nama' => auth()->user()->nama,
            'pesan' => $this->pesanBaru,
            'waktu' => now()->toIso8601String(),
            'lampiran' => $path ? ['/storage/'.$path] : [],
        ];

        $this->tiket->update([
            'riwayat_pesan' => $riwayat,
            'status' => 'diproses',
            'diperbarui_pada' => now()
        ]);

        $this->reset(['pesanBaru', 'lampiran']);
        $this->loadTiket();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Balasan berhasil dikirim.']);
    }

    public function updateStatus()
    {
        $this->tiket->update([
            'status' => $this->statusBaru,
            'prioritas' => $this->prioritasBaru,
            'diperbarui_pada' => now()
        ]);
        $this->dispatch('notifikasi', ['tipe' => 'info', 'pesan' => 'Status tiket diperbarui.']);
    }

    #[Title('Resolusi Tiket - Teqara Admin')]
    public function render()
    {
        return view('livewire.pengelola.layanan-pelanggan.detail-tiket-admin')
            ->layout('components.layouts.admin', ['header' => 'Pusat Resolusi']);
    }
}
