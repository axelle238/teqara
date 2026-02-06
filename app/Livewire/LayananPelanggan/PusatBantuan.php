<?php

namespace App\Livewire\LayananPelanggan;

use App\Models\TiketBantuan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class PusatBantuan
 * Tujuan: Gerbang dukungan pelanggan terpadu (FAQ & Tiketing).
 */
class PusatBantuan extends Component
{
    use WithFileUploads;

    // State Formulir Tiket
    public $subjek;
    public $kategori = 'umum'; // umum, teknis, penagihan, pesanan
    public $prioritas = 'rendah'; // rendah, sedang, tinggi
    public $pesan;
    public $lampiran;

    // State FAQ
    public $cariFaq = '';
    public $faqTerbuka = null;

    public function toggleFaq($index)
    {
        $this->faqTerbuka = $this->faqTerbuka === $index ? null : $index;
    }

    public function kirimTiket()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'subjek' => 'required|min:5|max:100',
            'pesan' => 'required|min:10',
            'lampiran' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($this->lampiran) {
            $path = $this->lampiran->store('tiket-bantuan', 'public');
        }

        TiketBantuan::create([
            'pengguna_id' => auth()->id(),
            'subjek' => $this->subjek,
            'kategori' => $this->kategori,
            'prioritas' => $this->prioritas,
            'status' => 'terbuka',
            'riwayat_pesan' => [
                [
                    'pengirim' => 'user',
                    'nama' => auth()->user()->nama,
                    'pesan' => $this->pesan,
                    'waktu' => now()->toIso8601String(),
                    'lampiran' => $path ? '/storage/'.$path : null,
                ]
            ],
        ]);

        $this->reset(['subjek', 'pesan', 'lampiran', 'kategori', 'prioritas']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Tiket bantuan berhasil dikirim. Tim kami akan segera merespons.']);
    }

    #[Title('Pusat Bantuan - Teqara')]
    public function render()
    {
        // Data Statis FAQ Enterprise
        $faqs = collect([
            [
                'q' => 'Bagaimana cara melacak pesanan saya?',
                'a' => 'Anda dapat melacak pesanan melalui menu "Profil > Riwayat Pesanan". Klik pada nomor faktur untuk melihat detail pergerakan logistik secara real-time.'
            ],
            [
                'q' => 'Apakah Teqara menyediakan garansi produk?',
                'a' => 'Tentu. Semua unit teknologi di Teqara dilindungi oleh Garansi Resmi Manufaktur (1-3 Tahun) dan Garansi Tukar Unit 7 Hari dari Teqara.'
            ],
            [
                'q' => 'Bagaimana cara menggunakan Poin Loyalitas?',
                'a' => 'Poin loyalitas dapat digunakan pada halaman Checkout. 1 Poin bernilai Rp 1. Anda dapat menggunakan poin hingga 50% dari total nilai belanja.'
            ],
            [
                'q' => 'Metode pembayaran apa saja yang tersedia?',
                'a' => 'Kami mendukung Transfer Bank Otomatis (Virtual Account), Kartu Kredit/Debit, E-Wallet (GoPay, OVO, Dana), dan QRIS.'
            ],
            [
                'q' => 'Apakah bisa melakukan pengiriman ke luar pulau?',
                'a' => 'Ya, Teqara bekerja sama dengan mitra logistik prioritas untuk menjangkau seluruh wilayah Indonesia dengan asuransi pengiriman penuh.'
            ],
        ])->filter(function($item) {
            return empty($this->cariFaq) || stripos($item['q'], $this->cariFaq) !== false;
        });

        return view('livewire.layanan-pelanggan.pusat-bantuan', [
            'faqs' => $faqs
        ])->layout('components.layouts.app');
    }
}
