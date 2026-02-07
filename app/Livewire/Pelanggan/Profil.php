<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pesanan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profil extends Component
{
    use WithFileUploads;

    // Tab State
    public $tabAktif = 'ringkasan'; 

    // Data Diri
    public $nama;
    public $email;
    public $nomor_telepon;
    public $foto_profil;
    public $foto_baru;

    public function mount()
    {
        $pengguna = auth()->user();
        $this->nama = $pengguna->nama;
        $this->email = $pengguna->email;
        $this->nomor_telepon = $pengguna->nomor_telepon;
        $this->foto_profil = $pengguna->foto_profil;
    }

    public function gantiTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function simpanProfil()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'nomor_telepon' => 'nullable|numeric',
            'foto_baru' => 'nullable|image|max:1024',
        ]);

        $data = [
            'nama' => $this->nama,
            'nomor_telepon' => $this->nomor_telepon,
        ];

        if ($this->foto_baru) {
            $path = $this->foto_baru->store('profil', 'public');
            $data['foto_profil'] = '/storage/'.$path;
            $this->foto_profil = $data['foto_profil'];
        }

        auth()->user()->update($data);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Profil berhasil diperbarui.']);
    }

    #[Title('Pusat Komando Pelanggan - Teqara')]
    public function render()
    {
        $pesananTerakhir = Pesanan::where('pengguna_id', auth()->id())
            ->with(['detailPesanan.produk'])
            ->latest()
            ->take(5)
            ->get();

        $totalBelanja = Pesanan::where('pengguna_id', auth()->id())
            ->where('status_pembayaran', 'lunas')
            ->sum('total_harga');

        $jumlahPesanan = Pesanan::where('pengguna_id', auth()->id())->count();
        
        $pengguna = auth()->user();
        $poin = $pengguna->poin_loyalitas;
        $level = $pengguna->level_member ?? 'Classic';
        
        $nextLevel = 'Silver';
        $targetNext = 2000000; 
        
        if ($totalBelanja >= 50000000) {
            $level = 'Platinum';
            $nextLevel = 'Max';
            $targetNext = $totalBelanja;
        } elseif ($totalBelanja >= 10000000) {
            $level = 'Gold';
            $nextLevel = 'Platinum';
            $targetNext = 50000000;
        } elseif ($totalBelanja >= 2000000) {
            $level = 'Silver';
            $nextLevel = 'Gold';
            $targetNext = 10000000;
        }

        $progressLevel = $nextLevel === 'Max' ? 100 : ($totalBelanja / $targetNext) * 100;

        return view('livewire.pelanggan.profil', [
            'pesananTerakhir' => $pesananTerakhir,
            'totalBelanja' => $totalBelanja,
            'jumlahPesanan' => $jumlahPesanan,
            'gamifikasi' => [
                'poin' => $poin,
                'level' => $level,
                'next_level' => $nextLevel,
                'progress' => $progressLevel,
                'sisa_target' => max(0, $targetNext - $totalBelanja)
            ]
        ])->layout('components.layouts.app');
    }
}
