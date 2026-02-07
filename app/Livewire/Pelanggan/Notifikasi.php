<?php

namespace App\Livewire\Pelanggan;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Notifikasi extends Component
{
    use WithPagination;

    public $filter = 'semua'; // semua, transaksi, info, promo

    public function getNotifikasiProperty()
    {
        // Simulasi data notifikasi karena tabel notifikasi spesifik belum ada di model sebelumnya.
        // Di production, gunakan model DatabaseNotification atau tabel custom.
        // Disini kita gunakan array statis/dummy yang 'terlihat' dinamis untuk demo Enterprise.
        
        $data = collect([
            [
                'id' => 1,
                'tipe' => 'transaksi',
                'judul' => 'Pesanan #INV-2024001 Berhasil Dikirim',
                'pesan' => 'Paket Anda sedang dalam perjalanan bersama kurir JNE.',
                'waktu' => now()->subHours(2),
                'dibaca' => false,
                'icon' => '🚚',
                'warna' => 'blue'
            ],
            [
                'id' => 2,
                'tipe' => 'promo',
                'judul' => 'Flash Sale Dimulai!',
                'pesan' => 'Dapatkan diskon hingga 80% untuk produk elektronik pilihan.',
                'waktu' => now()->subHours(5),
                'dibaca' => true,
                'icon' => '⚡',
                'warna' => 'yellow'
            ],
            [
                'id' => 3,
                'tipe' => 'info',
                'judul' => 'Selamat Datang di Level Gold',
                'pesan' => 'Selamat! Anda telah mencapai level Gold. Nikmati prioritas layanan.',
                'waktu' => now()->subDays(1),
                'dibaca' => true,
                'icon' => '🏆',
                'warna' => 'indigo'
            ],
            [
                'id' => 4,
                'tipe' => 'transaksi',
                'judul' => 'Pembayaran Diterima',
                'pesan' => 'Pembayaran untuk pesanan #INV-2024001 telah dikonfirmasi.',
                'waktu' => now()->subDays(2),
                'dibaca' => true,
                'icon' => '✅',
                'warna' => 'emerald'
            ]
        ]);

        if ($this->filter !== 'semua') {
            return $data->where('tipe', $this->filter);
        }

        return $data;
    }

    public function tandaiSemuaDibaca()
    {
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Semua notifikasi ditandai sudah dibaca.']);
    }

    #[Title('Pusat Notifikasi - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.notifikasi')
            ->layout('components.layouts.app');
    }
}
