<?php

namespace App\Livewire\Komponen;

use Livewire\Component;
use Livewire\Attributes\On;

class Notifikasi extends Component
{
    public $daftarNotifikasi = [];

    #[On('notifikasi')]
    public function tambahNotifikasi($data)
    {
        $id = uniqid();
        $this->daftarNotifikasi[$id] = [
            'id' => $id,
            'tipe' => $data['tipe'] ?? 'sukses', // sukses, error, info, peringatan
            'pesan' => $data['pesan'] ?? '',
        ];

        // Hapus otomatis setelah 5 detik menggunakan JavaScript dispatch
        $this->dispatch('hapus-notifikasi-otomatis', id: $id);
    }

    #[On('hapus-notifikasi')]
    public function hapusNotifikasi($id)
    {
        unset($this->daftarNotifikasi[$id]);
    }

    public function render()
    {
        return view('livewire.komponen.notifikasi');
    }
}
