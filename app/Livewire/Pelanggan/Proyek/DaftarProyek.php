<?php

namespace App\Livewire\Pelanggan\Proyek;

use App\Models\Proyek;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarProyek extends Component
{
    use WithPagination;

    public $nama_proyek;
    public $deskripsi;
    public $anggaran;
    public $tenggat;
    
    public $tambahMode = false;

    public function getProyekSayaProperty()
    {
        return Proyek::where('pengguna_id', auth()->id())
            ->withCount('items')
            ->latest()
            ->paginate(9);
    }

    public function simpan()
    {
        $this->validate([
            'nama_proyek' => 'required|min:3',
            'anggaran' => 'nullable|numeric',
            'tenggat' => 'nullable|date',
        ]);

        Proyek::create([
            'pengguna_id' => auth()->id(),
            'nama_proyek' => $this->nama_proyek,
            'deskripsi' => $this->deskripsi,
            'anggaran' => $this->anggaran,
            'selesai_tanggal' => $this->tenggat,
            'status' => 'perencanaan'
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Proyek baru berhasil dibuat.']);
        $this->reset(['nama_proyek', 'deskripsi', 'anggaran', 'tenggat', 'tambahMode']);
    }

    #[Title('Manajemen Proyek - Teqara Enterprise')]
    public function render()
    {
        return view('livewire.pelanggan.proyek.daftar-proyek')
            ->layout('components.layouts.app');
    }
}
