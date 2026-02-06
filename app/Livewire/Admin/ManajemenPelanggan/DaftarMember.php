<?php

namespace App\Livewire\Admin\ManajemenPelanggan;

use App\Models\LogAktivitas;
use App\Models\Pengguna;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DaftarMember
 * Tujuan: Manajemen basis data pelanggan (member) dan pengaturan_sistem otoritas akses.
 */
class DaftarMember extends Component
{
    use WithPagination;

    public $cari = '';

    public $filterPeran = '';

    public $filterSegmen = '';

    public $memberTerpilih = null;

    public $statistikMember = [];

    public function updatedCari()
    {
        $this->resetPage();
    }

    public function inspeksi($id)
    {
        $this->memberTerpilih = Pengguna::with(['pesanan.detailPesanan', 'alamat', 'tiketBantuan'])->findOrFail($id);

        // Hitung Analitik CRM 360
        $totalBelanja = $this->memberTerpilih->pesanan->where('status_pembayaran', 'lunas')->sum('total_harga');
        $frekuensiBelanja = $this->memberTerpilih->pesanan->count();
        $rataRataKeranjang = $frekuensiBelanja > 0 ? $totalBelanja / $frekuensiBelanja : 0;

        // Tentukan Segmen Pelanggan
        $segmen = 'Bronze';
        if ($totalBelanja > 50000000) {
            $segmen = 'Platinum';
        } elseif ($totalBelanja > 10000000) {
            $segmen = 'Gold';
        } elseif ($totalBelanja > 2000000) {
            $segmen = 'Silver';
        }

        $this->statistikMember = [
            'ltv' => $totalBelanja,
            'frekuensi' => $frekuensiBelanja,
            'aov' => $rataRataKeranjang,
            'segmen' => $segmen,
            'terakhir_login' => now(),
            'tiket_terbuka' => $this->memberTerpilih->tiketBantuan ? $this->memberTerpilih->tiketBantuan->where('status', '!=', 'selesai')->count() : 0,
        ];

        $this->dispatch('open-panel-inspeksi-member');
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
            'waktu' => now(),
        ]);

        $this->dispatch('notifikasi', ['tipe' => 'sukses', 'pesan' => "Peran {$pengguna->nama} berhasil diperbarui."]);
    }

    #[Title('Basis Data Member - Admin Teqara')]
    public function render()
    {
        $query = Pengguna::query()
            ->withCount('pesanan')
            ->withSum(['pesanan' => function ($q) {
                $q->where('status_pembayaran', 'lunas');
            }], 'total_harga')
            ->when($this->cari, function ($q) {
                $q->where('nama', 'like', '%'.$this->cari.'%')
                    ->orWhere('email', 'like', '%'.$this->cari.'%');
            })
            ->when($this->filterPeran, function ($q) {
                $q->where('peran', $this->filterPeran);
            });

        // Filter Segmentasi Cerdas
        if ($this->filterSegmen) {
            switch ($this->filterSegmen) {
                case 'vip':
                    $query->having('pesanan_sum_total_harga', '>', 50000000);
                    break;
                case 'loyal':
                    $query->having('pesanan_sum_total_harga', '>', 10000000);
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'passive':
                    $query->doesntHave('pesanan');
                    break;
            }
        }

        return view('livewire.admin.manajemen-pelanggan.daftar-member', [
            'daftarPengguna' => $query->latest()->paginate(10),
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Pengguna & Pelanggan']);
    }
}
