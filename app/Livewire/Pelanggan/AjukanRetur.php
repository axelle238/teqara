<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class AjukanRetur extends Component
{
    use WithFileUploads;

    public $pesanan_id;
    public $alasan;
    public $keterangan;
    public $bukti_foto = [];
    public $rekening_bank; // Opsional jika refund uang

    public function mount()
    {
        // Bisa menerima parameter pesanan_id via URL jika flow dari detail pesanan
        $this->pesanan_id = request()->query('pesanan');
    }

    public function getDaftarPesananProperty()
    {
        // Hanya pesanan 'selesai' dalam 7 hari terakhir yang bisa diretur
        return Pesanan::where('pengguna_id', auth()->id())
            ->where('status_pesanan', 'selesai')
            ->where('diperbarui_pada', '>=', now()->subDays(7))
            ->orderByDesc('diperbarui_pada')
            ->get();
    }

    public function ajukan()
    {
        $this->validate([
            'pesanan_id' => 'required',
            'alasan' => 'required',
            'keterangan' => 'required|min:10',
            'bukti_foto.*' => 'image|max:2048'
        ]);

        // Simpan logika retur (bisa ke tabel khusus 'retur_pesanan' atau tiket bantuan kategori retur)
        // Disini kita gunakan Tiket Bantuan sebagai handler retur untuk simplifikasi enterprise flow
        
        $lampiranPaths = [];
        foreach ($this->bukti_foto as $foto) {
            $lampiranPaths[] = $foto->store('retur', 'public');
        }

        \App\Models\TiketBantuan::create([
            'pengguna_id' => auth()->id(),
            'subjek' => 'Pengajuan Retur Pesanan #' . Pesanan::find($this->pesanan_id)->nomor_faktur,
            'kategori' => 'retur', // Pastikan kategori ini valid/ditangani
            'prioritas' => 'tinggi',
            'status' => 'terbuka',
            'riwayat_pesan' => [
                [
                    'pengirim' => 'user',
                    'nama' => auth()->user()->nama,
                    'pesan' => "Alasan: {$this->alasan}
Keterangan: {$this->keterangan}",
                    'waktu' => now()->toIso8601String(),
                    'lampiran' => $lampiranPaths
                ]
            ]
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Pengajuan retur berhasil dikirim. Tim kami akan segera menghubungi Anda.']);
        return redirect()->route('bantuan');
    }

    #[Title('Ajukan Pengembalian - Teqara Hub')]
    public function render()
    {
        return view('livewire.pelanggan.ajukan-retur')
            ->layout('components.layouts.app');
    }
}
