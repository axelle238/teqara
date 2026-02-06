<?php

namespace App\Livewire\Pelanggan;

use App\Models\AlamatPengiriman;
use App\Models\Pesanan;
use App\Models\RiwayatPoin;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profil extends Component
{
    use WithFileUploads;

    // Tab State
    public $tabAktif = 'ringkasan'; // ringkasan, pesanan, alamat, loyalitas, pengaturan

    // Data Diri
    public $nama;
    public $email;
    public $nomor_telepon;
    public $foto_profil;
    public $foto_baru;

    // Alamat Form
    public $alamatTerpilihId = null;
    public $label_alamat, $penerima, $telepon, $alamat_lengkap, $kota, $kode_pos;

    // Ganti Password
    public $sandi_lama;
    public $sandi_baru;
    public $sandi_baru_confirmation;

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

    // Alamat Management
    public function tambahAlamat()
    {
        $this->resetAlamatForm();
        $this->dispatch('open-slide-over', id: 'form-alamat');
    }

    public function editAlamat($id)
    {
        $alamat = AlamatPengiriman::where('pengguna_id', auth()->id())->findOrFail($id);
        $this->alamatTerpilihId = $alamat->id;
        $this->label_alamat = $alamat->label_alamat;
        $this->penerima = $alamat->penerima;
        $this->telepon = $alamat->telepon;
        $this->alamat_lengkap = $alamat->alamat_lengkap;
        $this->kota = $alamat->kota;
        $this->kode_pos = $alamat->kode_pos;

        $this->dispatch('open-slide-over', id: 'form-alamat');
    }

    public function simpanAlamat()
    {
        $this->validate([
            'label_alamat' => 'required',
            'penerima' => 'required',
            'telepon' => 'required',
            'alamat_lengkap' => 'required',
            'kota' => 'required',
        ]);

        $data = [
            'pengguna_id' => auth()->id(),
            'label_alamat' => $this->label_alamat,
            'penerima' => $this->penerima,
            'telepon' => $this->telepon,
            'alamat_lengkap' => $this->alamat_lengkap,
            'kota' => $this->kota,
            'kode_pos' => $this->kode_pos,
        ];

        if ($this->alamatTerpilihId) {
            AlamatPengiriman::find($this->alamatTerpilihId)->update($data);
            $pesan = 'Alamat berhasil diperbarui.';
        } else {
            AlamatPengiriman::create($data);
            $pesan = 'Alamat baru ditambahkan.';
        }

        $this->dispatch('close-slide-over', id: 'form-alamat');
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => $pesan]);
        $this->resetAlamatForm();
    }

    public function setUtama($id)
    {
        AlamatPengiriman::where('pengguna_id', auth()->id())->update(['is_utama' => false]);
        AlamatPengiriman::where('pengguna_id', auth()->id())->where('id', $id)->update(['is_utama' => true]);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Alamat utama berhasil disetel.']);
    }

    public function hapusAlamat($id)
    {
        AlamatPengiriman::where('pengguna_id', auth()->id())->where('id', $id)->delete();
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Alamat berhasil dihapus.']);
    }

    private function resetAlamatForm()
    {
        $this->reset(['alamatTerpilihId', 'label_alamat', 'penerima', 'telepon', 'alamat_lengkap', 'kota', 'kode_pos']);
    }

    public function gantiPassword()
    {
        $this->validate([
            'sandi_lama' => 'required|current_password',
            'sandi_baru' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update([
            'kata_sandi' => Hash::make($this->sandi_baru),
        ]);

        $this->reset(['sandi_lama', 'sandi_baru', 'sandi_baru_confirmation']);
        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => 'Kata sandi berhasil diubah.']);
    }

    public function getRiwayatPoinProperty()
    {
        return RiwayatPoin::where('pengguna_id', auth()->id())->latest()->take(10)->get();
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
            'alamat' => AlamatPengiriman::where('pengguna_id', auth()->id())->latest()->get(),
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
