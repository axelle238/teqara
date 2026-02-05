<?php

namespace App\Livewire\Admin\Pengguna;

use Livewire\Component;
use App\Models\Pengguna;
use App\Models\LogAktivitas;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class DaftarPengguna extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterPeran = '';

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function ubahPeran($id, $peranBaru)
    {
        $pengguna = Pengguna::findOrFail($id);
        $peranLama = $pengguna->peran;
        $pengguna->update(['peran' => $peranBaru]);

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'ubah_peran',
            'target' => $pengguna->nama,
            'pesan_naratif' => "Admin mengubah peran {$pengguna->nama} dari {$peranLama} menjadi {$peranBaru}",
            'waktu' => now()
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Peran {$pengguna->nama} berhasil diperbarui."]);
    }

    #[Title('Manajemen Pengguna - Admin')]
    public function render()
    {
        $query = Pengguna::query()
            ->when($this->cari, function($q) {
                $q->where('nama', 'like', '%' . $this->cari . '%')
                  ->orWhere('email', 'like', '%' . $this->cari . '%');
            })
            ->when($this->filterPeran, function($q) {
                $q->where('peran', $this->filterPeran);
            });

        return view('livewire.admin.pengguna.daftar-pengguna', [
            'daftarPengguna' => $query->latest()->paginate(10)
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Pengguna & Pelanggan']);
    }
}
