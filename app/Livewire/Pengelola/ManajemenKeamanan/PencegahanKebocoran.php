<?php

namespace App\Livewire\Pengelola\ManajemenKeamanan;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class PencegahanKebocoran extends Component
{
    use WithPagination;

    public $aturanDlp = [
        ['nama' => 'Kartu Kredit', 'pola' => '(?:\d[ -]*?){13,16}', 'aksi' => 'blokir', 'status' => 'aktif'],
        ['nama' => 'Email List Dump', 'pola' => '(?:[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?(\n|,|;)){5,}', 'aksi' => 'blokir', 'status' => 'aktif'],
        ['nama' => 'KTP / NIK', 'pola' => '\d{16}', 'aksi' => 'log', 'status' => 'aktif'],
        ['nama' => 'Source Code PHP', 'pola' => '<\?php', 'aksi' => 'blokir', 'status' => 'nonaktif'],
    ];

    public function getInsidenProperty()
    {
        return collect([
            [
                'waktu' => now()->subMinutes(15),
                'user' => 'Staff Gudang 1',
                'tipe' => 'Email List Dump',
                'konten' => 'user1@gmail.com, user2@yahoo.com, ... (500+)',
                'aksi_sistem' => 'Diblokir',
                'severity' => 'tinggi'
            ],
            [
                'waktu' => now()->subHours(2),
                'user' => 'Admin Keuangan',
                'tipe' => 'Kartu Kredit',
                'konten' => '4532-xxxx-xxxx-9088',
                'aksi_sistem' => 'Dicatat',
                'severity' => 'sedang'
            ],
            [
                'waktu' => now()->subHours(5),
                'user' => 'Tamu (Unauthenticated)',
                'tipe' => 'KTP / NIK',
                'konten' => '3201xxxxxxxxxxxx',
                'aksi_sistem' => 'Dicatat',
                'severity' => 'rendah'
            ]
        ]);
    }

    public function toggleAturan($index)
    {
        $status = $this->aturanDlp[$index]['status'];
        $this->aturanDlp[$index]['status'] = $status === 'aktif' ? 'nonaktif' : 'aktif';
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Status aturan DLP diperbarui.']);
    }

    #[Title('DLP - Pencegahan Kebocoran Data - Teqara Security')]
    public function render()
    {
        return view('livewire.pengelola.manajemen-keamanan.pencegahan-kebocoran', [
            'insiden' => $this->insiden
        ])->layout('components.layouts.admin');
    }
}
